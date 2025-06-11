<?php

use yii\db\Migration;

/**
 * Handles adding cover_image to table `user`.
 */
class m250524_125506_add_cover_image_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'cover_image', $this->string()->null()->after('profile_image'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'cover_image');
    }
}
