<?php


namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\Product;
use yii\web\UploadedFile;
use app\models\ProductImage;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Like;
use app\models\Comment;



class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
//#############INDEX START
public function actionIndex($offset = 0)
{
    $query = Product::find()->orderBy(['created_at' => SORT_DESC]);

    $pagination = new Pagination([
        'totalCount' => $query->count(),
        'defaultPageSize' => 10,
        'pageSizeLimit' => [1, 50],
        'params' => [],
        'route' => 'site/index',
        'pageParam' => 'page',
    ]);

    $products = $query
        ->offset($offset)
        ->limit($pagination->defaultPageSize)
        ->with('images', 'user') // eager load relations
        ->all();

    // AJAX load more request
    if (Yii::$app->request->isAjax) {
        return $this->renderPartial('_feed_items', [
            'products' => $products,
        ]);
    }

    // Normal page load
    return $this->render('index', [
        'products' => $products,
        'pagination' => $pagination,
    ]);
}


    // LOGIN AACTION
    public function actionLogin()
    {
        $loginModel = new LoginForm();
        $signupModel = new SignupForm();

        if ($loginModel->load(Yii::$app->request->post()) && $loginModel->login()) {
            return $this->goHome();
        }

        return $this->render('login', [
            'signupModel' => $signupModel,
        ]);
    }

    // LOGOUT ACTION
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    // PROFILE DISPLAY ACTION
    public function actionProfile()
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return $this->redirect(['site/login']);
        }

        return $this->render('profile', [
            'user' => $user,
            'products' => Product::find()->where(['user_id' => $user->id])->all(),
            'productModel' => new Product(),
        ]);
    }

    // UPDATE PROFILE ACTION
public function actionUpdateProfile()
{
    $user = Yii::$app->user->identity;

    if (!$user) {
        return $this->redirect(['site/login']);
    }
    
    $oldProfileImage = $user->profile_image;
    $oldCoverImage = $user->cover_image;


    if (Yii::$app->request->isPost) {
        $user->load(Yii::$app->request->post());

        // Handle profile image
        $uploadedProfile = UploadedFile::getInstance($user, 'profile_image');
        if ($uploadedProfile) {
            $profilePath = 'uploads/profile_' . $user->id . '_' . time() . '.' . $uploadedProfile->extension;
            if ($uploadedProfile->saveAs($profilePath)) {
                $user->profile_image = $profilePath;
            } else {
                $user->profile_image = $oldProfileImage;
                Yii::$app->session->setFlash('error', 'Failed to upload profile image.');
            }
        } else {
            $user->profile_image = $oldProfileImage;
        }

        // Handle cover image
        $uploadedCover = UploadedFile::getInstance($user, 'cover_image');
        if ($uploadedCover) {
            $coverPath = 'uploads/cover_' . $user->id . '_' . time() . '.' . $uploadedCover->extension;
            if ($uploadedCover->saveAs($coverPath)) {
                $user->cover_image = $coverPath;
            } else {
                $user->cover_image = $oldCoverImage;
                Yii::$app->session->setFlash('error', 'Failed to upload cover image.');
            }
        } else {
            $user->cover_image = $oldCoverImage;
        }

        if ($user->save()) {
            Yii::$app->session->setFlash('success', 'Profile updated successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to update profile.');
        }
    }

    return $this->redirect(['site/profile']);
}




    // UPLOAD PRODUCT ACTION
public function actionUploadProduct()
{
    $model = new Product();

    if (Yii::$app->request->isPost) {
        $model->load(Yii::$app->request->post());
        $model->user_id = Yii::$app->user->id;

        // Get uploaded files for the 'imageFiles' attribute
        $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');

        if ($model->validate() && $model->save()) {
            $savedCount = 0;
            foreach ($model->imageFiles as $file) {
                if ($savedCount >= 5) break; // max 5 images

                $filename = 'uploads/' . uniqid() . '.' . $file->extension;
                if ($file->saveAs($filename)) {
                    // Save image record
                    $productImage = new \app\models\ProductImage();
                    $productImage->product_id = $model->id;
                    $productImage->image_path = $filename;
                    $productImage->save(false); // no validation
                    $savedCount++;
                }
            }
            Yii::$app->session->setFlash('success', 'Product uploaded successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to upload product.');
        }
    }

    return $this->redirect(['site/profile']);
}


    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if ($user && Yii::$app->user->login($user)) {
                return $this->redirect(['site/profile']);
            }
        }

        return $this->render('signup', ['model' => $model]);
    }

    //PRODUCT DETAILS 
    public function actionProductDetails($id)
    {
        $product = Product::find()->with('images')->where(['id' => $id])->one();

        if (!$product) {
            throw new NotFoundHttpException("Product not found.");
        }

        return $this->renderPartial('_product_details', ['product' => $product]);
    }

//*************************PRODUCT********************* */
    public function actionProduct($id)
{
    $product = Product::findOne($id);
    if (!$product) {
        throw new \yii\web\NotFoundHttpException("Product not found.");
    }

    $newComment = new Comment();

    if ($newComment->load(Yii::$app->request->post()) && Yii::$app->user->id) {
        $newComment->user_id = Yii::$app->user->id;
        $newComment->product_id = $product->id;
        $newComment->created_at = time();
        if ($newComment->save()) {
            return $this->refresh();
        }
    }

    $comments = Comment::find()
        ->where(['product_id' => $product->id])
        ->orderBy(['created_at' => SORT_DESC])
        ->all();

    return $this->render('product', [
        'model' => $product,
        'comments' => $comments,
        'newComment' => $newComment,
    ]);
}
//****************************LOADPRODUCT***********
public function actionLoadProducts($page = 1)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    try {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $products = Product::find()
            ->with('images', 'user')
            ->orderBy(['created_at' => SORT_DESC])
            ->offset($offset)
            ->limit($limit)
            ->all();

        if (empty($products)) {
            return ['html' => '<div style="color:red;">No products found.</div>'];
        }

        $html = $this->renderPartial('_feed_items', ['products' => $products]);

        return ['html' => $html];

    } catch (\Exception $e) {
        return ['html' => '<div style="color:red;">Error: ' . $e->getMessage() . '</div>'];
    }
}








}
