<?php
/*
 * 管理画面
*/
// メニュー項目 非表示
function edit_admin_menus() {
  global $menu;
  remove_menu_page ( 'edit.php?post_type=page' );
  remove_menu_page ( 'edit-comments.php' );
}
add_action( 'admin_menu', 'edit_admin_menus' );



/*
 * 投稿
*/
// アイキャッチ 有効化
add_theme_support('post-thumbnails');
set_post_thumbnail_size( 400, 400, true );


// wyswig 非表示
function remove_wysiwyg() {
    remove_post_type_support( 'post', 'editor' );
}
add_action( 'init' , 'remove_wysiwyg' );


// 表示オプション変更
function my_remove_meta_boxes() {
  remove_meta_box('authordiv', 'post', 'normal'); // オーサー
  remove_meta_box('categorydiv', 'post', 'normal'); // カテゴリー
  remove_meta_box('commentstatusdiv', 'post', 'normal'); // ディスカッション
  remove_meta_box('commentsdiv', 'post', 'normal'); // コメント
  remove_meta_box('formatdiv', 'post', 'normal'); // フォーマット
  remove_meta_box('pageparentdiv', 'post', 'normal'); // ページ属性
  remove_meta_box('postcustom', 'post', 'normal'); // カスタムフィールド
  remove_meta_box('postexcerpt', 'post', 'normal'); // 抜粋
  remove_meta_box('revisionsdiv', 'post', 'normal'); // リビジョン
  remove_meta_box('slugdiv', 'post', 'normal'); // スラッグ
  remove_meta_box('tagsdiv-post_tag', 'post', 'normal'); // タグ
  remove_meta_box('trackbacksdiv', 'post', 'normal'); // トラックバック
}
add_action('admin_menu', 'my_remove_meta_boxes');


// 1カラム
function one_columns_screen_layout() {
  return 1;
}
add_filter( 'get_user_option_screen_layout_post', 'one_columns_screen_layout' );


// 投稿　表示オプション並び替え
function custom_menu_order($menu_old) {
    if (!$menu_old) return true;

    return array(
        'index.php', // ダッシュボード
        'edit.php', // 投稿
        'edit.php?post_type=page', // 固定ページ
        'edit-comments.php', // コメント
        'separator1', // 区切り線１
        'upload.php', // メディア
        'link-manager.php', // リンク
        'users.php', // ユーザー
        'separator2', // 区切り線２
        'themes.php', // テーマ
        'plugins.php', // プラグイン
        'tools.php', // ツール
        'options-general.php', // 設定
        'separator-last', // 区切り線３
    );
}
add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');


// 公開 1番下
add_action( 'admin_menu', 'move_submit_metabox' );
function move_submit_metabox() {
   remove_meta_box( 'submitdiv', 'post', 'side' );
   add_meta_box( 'submitdiv ', __( 'Publish' ), 'post_submit_meta_box', 'post', 'side', 'low' );
}


// 自動タイトル
function replace_post_title($title) {
    global $post;
    //post_typeを判定(post, page, カスタム投稿)
    if( $post->post_type == '投稿タイプ' ){
        if($title === ""){
                    $title .= '自動投稿するタイトル名';
        }
    }
    return $title;
}
add_filter('title_save_pre', 'replace_post_title');









// admin_menu にフック
add_action('admin_menu', 'register_custom_menu_page');
function register_custom_menu_page() {
    // add_menu_page でカスタムメニューを追加
    add_menu_page('サイト設定', 'サイト設定', 0, 'site_settings', 'create_custom_menu_page', '', 3);
}
function create_custom_menu_page() {
    // カスタムメニューページを読み込む
    require TEMPLATEPATH.'/admin/site_settings.php';
}









//画像アップロード用のタグを出力する
function genelate_upload_image_tag($name, $value){?>
  <input name="<?php echo $name; ?>" type="text" value="<?php echo $value; ?>" />
  <input type="button" name="<?php echo $name; ?>_slect" value="選択" />
  <input type="button" name="<?php echo $name; ?>_clear" value="クリア" />
  <div id="<?php echo $name; ?>_thumbnail" class="uploded-thumbnail">
    <?php if ($value): ?>
      <?php echo wp_get_attachment_image( $value, full ); ?>
    <?php endif ?>
  </div>


  <script type="text/javascript">
  (function ($) {

      var custom_uploader;

      $("input:button[name=<?php echo $name; ?>_slect]").click(function(e) {

          e.preventDefault();

          if (custom_uploader) {

              custom_uploader.open();
              return;

          }

          custom_uploader = wp.media({

              title: "画像を選択してください",

              /* ライブラリの一覧は画像のみにする */
              library: {
                  type: "image"
              },

              button: {
                  text: "画像の選択"
              },

              /* 選択できる画像は 1 つだけにする */
              multiple: false

          });

          custom_uploader.on("select", function() {

              var images = custom_uploader.state().get("selection");

              /* file の中に選択された画像の各種情報が入っている */
              images.each(function(file){

                  /* テキストフォームと表示されたサムネイル画像があればクリア */
                  $("input:text[name=<?php echo $name; ?>]").val("");
                  $("#<?php echo $name; ?>_thumbnail").empty();

                  /* テキストフォームに画像の URL を表示 */
                  $("input:text[name=<?php echo $name; ?>]").val(file.id);

                  /* プレビュー用に選択されたサムネイル画像を表示 */
                  $("#<?php echo $name; ?>_thumbnail").append('<img src="'+file.attributes.sizes.full.url+'" />');

              });
          });

          custom_uploader.open();

      });

      /* クリアボタンを押した時の処理 */
      $("input:button[name=<?php echo $name; ?>_clear]").click(function() {

          $("input:text[name=<?php echo $name; ?>]").val("");
          $("#<?php echo $name; ?>_thumbnail").empty();

      });

  })(jQuery);
  </script>
  <?php
}


function my_admin_scripts() {
  //メディアアップローダの javascript API
  wp_enqueue_media();
}
add_action( 'admin_print_scripts', 'my_admin_scripts' );
