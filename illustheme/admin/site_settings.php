<?php
$setting = array(
  'blogname' => array(
    'form_type' => 'text',
    'label' => 'サイトのタイトル',
    'description' => '',
    'value' => '',
  ),
  'blogdescription' => array(
    'form_type' => 'text',
    'label' => 'サイトの説明文',
    'description' => '',
    'value' => '',
  ),
  'favicon' => array(
    'form_type' => 'img',
    'label' => 'ファビコン',
    'description' => '拡張子(.ico)',
    'value' => '',
  ),
  'touch_icon' => array(
    'form_type' => 'img',
    'label' => 'タッチアイコン',
    'description' => '推奨サイズ：180×180',
    'value' => '',
  ),
  'eyecatch' => array(
    'form_type' => 'img',
    'label' => 'アイキャッチ',
    'description' => '推奨サイズ：1920×1000',
    'value' => '',
  ),
  'banner' => array(
    'form_type' => 'img',
    'label' => 'サイトバナー',
    'description' => 'サイズ：468×100',
    'value' => '',
  ),
  'user_icon' => array(
    'form_type' => 'img',
    'label' => 'ユーザーアイコン',
    'description' => '',
    'value' => '',
  ),
  'user_name' => array(
    'form_type' => 'text',
    'label' => 'ユーザー名',
    'description' => '',
    'value' => '',
  ),
  'user_name_yomi' => array(
    'form_type' => 'text',
    'label' => 'ユーザー名（yomi）',
    'description' => '',
    'value' => '',
  ),
  'user_profile' => array(
    'form_type' => 'text',
    'label' => 'プロフィール',
    'description' => '',
    'value' => '',
  ),
  'pixiv' => array(
    'form_type' => 'text',
    'label' => 'pixiv',
    'description' => '',
    'value' => '',
  ),
  'twitter' => array(
    'form_type' => 'text',
    'label' => 'Twitter',
    'description' => '',
    'value' => '',
  ),
  'tumblr' => array(
    'form_type' => 'text',
    'label' => 'Tumblr',
    'description' => '',
    'value' => '',
  ),
  'instagram' => array(
    'form_type' => 'text',
    'label' => 'Instagram',
    'description' => '',
    'value' => '',
  ),
  'facebook' => array(
    'form_type' => 'text',
    'label' => 'Facebook',
    'description' => '',
    'value' => '',
  ),
  'contact_description' => array(
    'form_type' => 'text',
    'label' => 'お問い合わせ説明文',
    'description' => '',
    'value' => '',
  ),
  'contact_shortcode' => array(
    'form_type' => 'text',
    'label' => 'お問い合わせショートコード',
    'description' => '',
    'value' => '',
  ),
  'google_analytics' => array(
    'form_type' => 'text',
    'label' => 'Google Analytics',
    'description' => 'Google Analyticsのコードをそのままご入力してください。',
    'value' => '',
  ),
);



$prefix = 'it_';
foreach($setting as $key => $val){
  $prefixKey = $prefix . $key;

  // 配列代入
  if($val === '') {
    if($key === 'blogname' || $key === 'blogdescription'){
      $setting[$key]['value'] = get_option($key);
    } else {
      if( get_option($prefixKey) ){
        $setting[$key]['value'] = get_option($prefixKey);
      } else {
        add_option($prefixKey);
      }
    }
  }

  if($_REQUEST[$key]) {
    update_option($key, $_REQUEST[$key]);
  } else if($_REQUEST[$prefixKey]) {
    update_option($prefixKey, htmlentities($_REQUEST[$prefixKey]));
  } else if($_REQUEST[$prefixKey] === '') {
    update_option($prefixKey, '');
  };
};
?>



<h2><?php print get_template(); ?>の設定</h2>

<form method="post" action="admin.php?page=site_settings">
  <table class="form-table">
    <?php
      foreach ($setting as $key => $val) :
      $prefixKey = $prefix . $key;
    ?>
      <?php if ($setting[$key]['form_type'] === 'text' && $key === 'blogname' or $key === 'blogdescription' ) : ?>
        <tr valign="top">
          <th scope="row"><label for="<?php echo $key; ?>"><?php echo $setting[$key]['label']; ?></label></th>
          <td><input name="<?php echo $key; ?>" type="text" value="<?php echo get_option($key); ?>" class="regular-text"></td>
        </tr>
      <?php elseif ($setting[$key]['form_type'] === 'text') : ?>
        <tr valign="top">
          <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
          <td><input name="<?php echo $prefixKey; ?>" type="text" value="<?php echo get_option($prefixKey); ?>" class="regular-text"></td>
        </tr>
      <?php elseif ($setting[$key]['form_type'] === 'img') : ?>
        <tr valign="top">
          <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
          <td><?php genelate_upload_image_tag($prefixKey, get_option($prefixKey)); ?>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </table>
  <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="変更を保存"></p>
</form>
