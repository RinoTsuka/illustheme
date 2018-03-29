<?php
$setting = array(
  'blogname' => array(
    'form_type' => 'text',
    'punctuation' => 'サイトの情報',
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
  'themecolor' => array(
    'form_type' => 'select',
    'label' => 'テーマカラー',
    'description' => '',
    'value' => array(
      'gray',
      'red',
      'pink',
      'grape',
      'violet',
      'indigo',
      'blue',
      'cyan',
      'teal',
      'green',
      'lime',
      'yellow',
      'orange',
    )
  ),
  'google_analytics' => array(
    'form_type' => 'textarea',
    'label' => 'Google Analytics',
    'description' => 'Google Analyticsのコードをそのままご入力してください。',
    'value' => '',
  ),
  'favicon' => array(
    'form_type' => 'img',
    'punctuation' => 'ファビコン',
    'label' => 'ファビコン',
    'description' => '推奨：180×180(.png)',
    'value' => '',
  ),
  'eyecatch' => array(
    'form_type' => 'img',
    'punctuation' => 'アイキャッチ',
    'label' => 'アイキャッチ',
    'description' => '推奨サイズ：1920×1000',
    'value' => '',
  ),
  'banner' => array(
    'form_type' => 'img',
    'punctuation' => 'サイトバナー',
    'label' => 'サイトバナー',
    'description' => 'サイズ：468×100',
    'value' => '',
  ),
  'user_icon' => array(
    'form_type' => 'img',
    'punctuation' => 'ユーザーアイコン',
    'label' => 'ユーザーアイコン',
    'description' => '',
    'value' => '',
  ),
  'user_name' => array(
    'form_type' => 'text',
    'punctuation' => 'ユーザー情報',
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
    'punctuation' => 'SNS',
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
    'description' => 'Contact Form 7のショートコードが入力できます。',
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
        $setting[$key]['value'] = $prefixKey;
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



<div class="wrap">
  <h1 class="wp-heading-inline">投稿の編集</h1>
  <div id="poststuff">

    <form method="post" action="admin.php?page=site_settings">
      <?php
        $i = 0;
        foreach ($setting as $key => $val) :
        $prefixKey = $prefix . $key;
      ?>
        <?php if ($setting[$key]['punctuation'] == true) : ?>
          <?php if ($i !== 0) : ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <div class="postbox-container">
            <div class="meta-box-sortables ui-sortable">
              <div class="postbox">
                <h2 class="hndle ui-sortable-handle"><span><?php echo $setting[$key]['punctuation']; ?></span></h2>
                <div class="inside">
                  <table class="form-table">
                    <?php if ($setting[$key]['form_type'] === 'text' && $key === 'blogname' or $key === 'blogdescription' ) : ?>
                      <tr class="<?php echo $prefixKey; ?>">
                        <th scope="row"><label for="<?php echo $key; ?>"><?php echo $setting[$key]['label']; ?></label></th>
                        <td><input name="<?php echo $key; ?>" type="text" value="<?php echo stripslashes(get_option($key)); ?>" class="regular-text"></td>
                      </tr>
                    <?php elseif ($setting[$key]['form_type'] === 'text') : ?>
                      <tr class="<?php echo $prefixKey; ?>">
                        <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
                        <td><input name="<?php echo $prefixKey; ?>" type="text" value="<?php echo stripslashes(get_option($prefixKey)); ?>" class="regular-text"></td>
                      </tr>
                    <?php elseif ($setting[$key]['form_type'] === 'select') : ?>
                      <tr class="<?php echo $prefixKey; ?>">
                        <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
                        <td><select name="<?php echo $prefixKey; ?>" class="regular-text">
                          <?php foreach ($setting[$key]['value'] as $key => $val) : ?>
                            <?php if (get_option($prefixKey) === $val) : ?>
                              <option value="<?php echo $val; ?>" selected><?php echo $val; ?></option>
                            <?php else : ?>
                              <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </select></td>
                    <?php elseif ($setting[$key]['form_type'] === 'textarea') : ?>
                      <tr class="<?php echo $prefixKey; ?>">
                        <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
                        <td><textarea name="<?php echo $prefixKey; ?>" class="regular-text"><?php echo stripslashes(get_option($prefixKey)) ?></textarea></td>
                      </tr>
                    <?php elseif ($setting[$key]['form_type'] === 'img') : ?>
                      <tr class="<?php echo $prefixKey; ?>">
                        <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
                        <td><?php genelate_upload_image_tag($prefixKey, get_option($prefixKey)); ?></td>
                      </tr>
                    <?php endif; ?>
        <?php elseif ($setting[$key]['punctuation'] == false) : ?>
          <?php if ($setting[$key]['form_type'] === 'text' && $key === 'blogname' or $key === 'blogdescription' ) : ?>
            <tr class="<?php echo $prefixKey; ?>">
              <th scope="row"><label for="<?php echo $key; ?>"><?php echo $setting[$key]['label']; ?></label></th>
              <td><input name="<?php echo $key; ?>" type="text" value="<?php echo stripslashes(get_option($key)); ?>" class="regular-text"></td>
            </tr>
          <?php elseif ($setting[$key]['form_type'] === 'text') : ?>
            <tr class="<?php echo $prefixKey; ?>">
              <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
              <td><input name="<?php echo $prefixKey; ?>" type="text" value="<?php echo stripslashes(get_option($prefixKey)); ?>" class="regular-text"></td>
            </tr>
          <?php elseif ($setting[$key]['form_type'] === 'select') : ?>
            <tr class="<?php echo $prefixKey; ?>">
              <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
              <td><select name="<?php echo $prefixKey; ?>" class="regular-text">
                <?php foreach ($setting[$key]['value'] as $key => $val) : ?>
                  <?php if (get_option($prefixKey) === $val) : ?>
                    <option value="<?php echo $val; ?>" selected><?php echo $val; ?></option>
                  <?php else : ?>
                    <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select></td>
            </tr>
          <?php elseif ($setting[$key]['form_type'] === 'textarea') : ?>
            <tr class="<?php echo $prefixKey; ?>">
              <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
              <td><textarea name="<?php echo $prefixKey; ?>" class="regular-text"><?php echo stripslashes(get_option($prefixKey)) ?></textarea></td>
            </tr>
          <?php elseif ($setting[$key]['form_type'] === 'img') : ?>
            <tr class="<?php echo $prefixKey; ?>">
              <th scope="row"><label for="<?php echo $prefixKey; ?>"><?php echo $setting[$key]['label']; ?></label></th>
              <td><?php genelate_upload_image_tag($prefixKey, get_option($prefixKey)); ?></td>
            </tr>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($i === 0) : ?>
          <?php $i = 1; ?>
        <?php endif; ?>
      <?php endforeach; ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="変更を保存"></p>
    </form>

  </div>
</div>
