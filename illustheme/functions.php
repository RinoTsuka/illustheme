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


// admin_menu にフック
add_action('admin_menu', 'register_custom_menu_page');
function register_custom_menu_page() {
  // add_menu_page でカスタムメニューを追加
  add_menu_page('サイト設定', 'サイト設定', 0, 'site_settings', 'create_custom_menu_page', '', 2);
}
function create_custom_menu_page() {
  // カスタムメニューページを読み込む
  require TEMPLATEPATH.'/admin/site_settings.php';
}


function custom_post_labels( $labels ) {
  $labels->menu_name = 'ギャラリー'; // 投稿
  $labels->featured_image = 'ギャラリー画像'; // アイキャッチ画像
	return $labels;
}
add_filter( 'post_type_labels_post', 'custom_post_labels' );




// カスタム投稿タイプ
// css
function admin_style(){
    wp_enqueue_style( 'admin_style', get_template_directory_uri().'/css/admin.min.css' );
}
add_action( 'admin_enqueue_scripts', 'admin_style' );


function create_post_type() {
  $exampleSupports = [  // supports のパラメータを設定する配列（初期値だと title と editor のみ投稿画面で使える）
    'title',  // 記事タイトル
    'thumbnail',  // アイキャッチ画像
  ];
  register_post_type( 'banner',  // カスタム投稿名
    array(
      'label' => 'リンク集',  // 管理画面の左メニューに表示されるテキスト
      'public' => true,  // 投稿タイプをパブリックにするか否か
      'has_archive' => true,  // アーカイブを有効にするか否か
      'menu_position' => 4,  // 管理画面上でどこに配置するか今回の場合は「投稿」の下に配置
      'supports' => $exampleSupports  // 投稿画面でどのmoduleを使うか的な設定
    )
  );
}
add_action( 'init', 'create_post_type' );

function custom_post_one_columns_screen_layout() {
  return 1;
}
add_filter( 'get_user_option_screen_layout_banner', 'custom_post_one_columns_screen_layout' );


//画像アップロード用のタグを出力する
function genelate_upload_image_tag($name, $value){?>
  <input name="<?php echo $name; ?>" type="text" value="<?php echo $value; ?>" class="upload_form" />
  <a href="#" id="<?php echo $name; ?>_slect" class="mediauploader_slect">画像を設定</a>
  <div id="<?php echo $name; ?>_thumbnail" class="uploded-thumbnail">
    <?php if ($value): ?>
      <?php echo wp_get_attachment_image( $value, full ); ?>
      <div><div id="<?php echo $name; ?>_clear" class="mediauploader_clear">画像を削除</div></div>
    <?php endif ?>
  </div>

  <script type="text/javascript">
  (function ($) {
    var custom_uploader;
    $("#<?php echo $name; ?>_slect").click(function(e) {
      e.preventDefault();
      if (custom_uploader) {
        custom_uploader.open();
        return;
      }

      custom_uploader = wp.media({
        title: "画像を選択してください",
        library: {
          type: "image"
        },
        button: {
          text: "画像の選択"
        },
        multiple: false
      });

      custom_uploader.on("select", function() {
        var images = custom_uploader.state().get("selection");
        images.each(function(file){
          $("input:text[name=<?php echo $name; ?>]").val("");
          $("#<?php echo $name; ?>_thumbnail").empty();
          $("input:text[name=<?php echo $name; ?>]").val(file.id);
          $("#<?php echo $name; ?>_thumbnail").append('<img src="'+file.attributes.sizes.full.url+'" class="uploded-thumbnail-img" /><div><div id="<?php echo $name; ?>_clear" class="mediauploader_clear">画像を削除</div></div>');
        });
      });
      custom_uploader.open();
    });
    $(document).on("click", "#<?php echo $name; ?>_clear", function () {
      $("input:text[name=<?php echo $name; ?>]").val("");
      $("#<?php echo $name; ?>_thumbnail").empty();
    });
  })(jQuery);
  </script>
  <?php
}

function my_admin_scripts() {
  wp_enqueue_media();
}
add_action( 'admin_print_scripts', 'my_admin_scripts' );



/*
 * 投稿
*/
// アイキャッチ 有効化
add_theme_support('post-thumbnails');
set_post_thumbnail_size( 400, 400, true );
// サムネイルサイズ追加
add_image_size( 'favicon', '180', '180', true);

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


// 固定カスタムフィールドボックス
function add_link_fields() {
  add_meta_box( 'link_setting', 'リンクの情報', 'insert_link_fields', 'banner', 'normal');
}
add_action('admin_menu', 'add_link_fields');

// カスタムフィールドの入力エリア
function insert_link_fields() {
  global $post;
  echo 'URL： <input type="text" name="link_name" value="'.get_post_meta($post->ID, 'link_name', true).'" size="50" /><br>';
  echo 'バナーコード： <input type="text" name="link_code" value="'.esc_html(get_post_meta($post->ID, 'link_code', true)).'" size="50" />';
}

// カスタムフィールドの値を保存
function save_link_fields( $post_id ) {
  if(!empty($_POST['link_name'])){
    update_post_meta($post_id, 'link_name', $_POST['link_name'] );
  }else{
    delete_post_meta($post_id, 'link_name');
  }
  if(!empty($_POST['link_code'])){
    update_post_meta($post_id, 'link_code', $_POST['link_code'] );
  }else{
    delete_post_meta($post_id, 'link_code');
  }
}
add_action('save_post', 'save_link_fields');


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
