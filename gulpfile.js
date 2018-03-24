var gulp = require("gulp");

var htmlmin = require('gulp-htmlmin');
var replace = require('gulp-replace');

var sass = require("gulp-sass");
var cleanCSS = require('gulp-clean-css');
var cmq = require('gulp-combine-media-queries');
var autoprefixer = require("gulp-autoprefixer");
var sourcemaps =require('gulp-sourcemaps');

var uglify = require('gulp-uglify');
var concat = require("gulp-concat");

var header = require('gulp-header');
var replace = require('gulp-replace');
var plumber = require("gulp-plumber");
var notify = require("gulp-notify");
var rename = require("gulp-rename");
var browser = require("browser-sync");

var imagemin = require("gulp-imagemin");
var jpegtran = require('imagemin-jpegtran');
var pngquant = require('imagemin-pngquant')

var ghPages = require('gulp-gh-pages');



/* variable
--------------------*/
var pkg = require('./package.json');
var src = 'src/';
var docs = 'docs/';

var demo = src + 'docs/';
var theme = pkg.name + '/';
var wordpress = 'wordpress/wp-content/themes/' + pkg.name + '/';

var img = 'img/';
var publicImg = img + 'public/';
var privateImg = img + 'private/';



/* header
--------------------*/
var wpHeader = [
  '/*',
  'Theme Name: ' + pkg.name,
  'Theme URL: https://rinotsuka.github.io/' + pkg.name + '/',
  'Description: ' + pkg.description,
  'Author: ' + pkg.author,
  'Version: ' + pkg.version,
  'License: ' + pkg.license,
  '*/'
].join('\n');
var cssHeader = [
  '/*!',
  ' *  ' + pkg.name,
  ' *  https://rinotsuka.github.io/' + pkg.name + '/blob/master/LICENSE',
  ' * ' + pkg.license,
  ' *',
  ' *  open-color',
  ' *  https://yeun.github.io/open-color/',
  ' *  MIT License',
  ' *',
  ' *  minireset.css v0.0.3',
  ' *  github.com/jgthms/minireset.css',
  ' *  MIT License',
  ' */' + '\n',
].join('\n');
var jsHeader = [
  '/*',
  ' * Version: 1.8.0',
  ' * Author: Ken Wheeler',
  ' * Website: http://kenwheeler.github.io',
  ' * Docs: http://kenwheeler.github.io/slick',
  ' * Repo: http://github.com/kenwheeler/slick',
  ' * Issues: http://github.com/kenwheeler/slick/issues',
  ' *',
  ' * Lightbox v2.10.0',
  ' * by Lokesh Dhakar',
  ' * More info:',
  ' * http://lokeshdhakar.com/projects/lightbox2/',
  ' * Copyright 2007, 2018 Lokesh Dhakar',
  ' * Released under the MIT license',
  ' * https://github.com/lokesh/lightbox2/blob/master/LICENSE',
  ' *',
  ' */' + '\n',
].join('\n');



/* server
--------------------*/
gulp.task('server', function() {
  browser({
    server: {
      baseDir: docs
    }
    //proxy: 'localhost:8004'
  });
});



/* license
--------------------*/
gulp.task('license', function(){
  gulp.src(src + 'license')
    .pipe(plumber({
      errorHandler: notify.onError('Error: <%= error.message %>')
    }))
    .pipe(gulp.dest(theme))
    .pipe(gulp.dest(wordpress))
    .pipe(browser.reload({stream:true}))
});



/* html
--------------------*/
gulp.task('html', function(){
  gulp.src(demo + '**/*.html', {base: demo})
    .pipe(plumber({
      errorHandler: notify.onError('Error: <%= error.message %>')
    }))
    .pipe(replace('class="header__heading-sub">ver<', 'class="header__heading-sub">ver ' + pkg.version + '<'))
    .pipe(htmlmin({collapseWhitespace: true}))
    .pipe(gulp.dest(docs))
    .pipe(browser.reload({stream:true}))
});



/* php
--------------------*/
gulp.task('php', function(){
  gulp.src(src + '**/*.php', {base: src})
    .pipe(plumber({
      errorHandler: notify.onError('Error: <%= error.message %>')
    }))
    .pipe(gulp.dest(theme))
    .pipe(gulp.dest(wordpress))
    .pipe(browser.reload({stream:true}))
});



/* sass
--------------------*/
gulp.task('sass', function() {
  // wordpress style.css
  gulp.src(src + 'style.css')
    .pipe(header(wpHeader))
    .pipe(gulp.dest(theme))
    .pipe(gulp.dest(wordpress))
  // theme
  gulp.src(src + 'scss/**/*.scss')
    .pipe(plumber({
      errorHandler: notify.onError('Error: <%= error.message %>')
    }))
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(autoprefixer())
    .pipe(cmq())
    .pipe(cleanCSS())
    .pipe(rename({
      extname: '.min.css'
    }))
    .pipe(replace(/@charset "UTF-8";/g, ''))
    .pipe(header(cssHeader))
    .pipe(header('@charset "UTF-8";\n'))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(docs + 'css/'))
    .pipe(gulp.dest(theme + 'css/'))
    .pipe(gulp.dest(wordpress + 'css/'))
    .pipe(browser.reload({stream:true}))
});



/* js
--------------------*/
gulp.task('js', function(){
  gulp.src(src + 'js/**/*.js')
    .pipe(plumber({
      errorHandler: notify.onError('Error: <%= error.message %>')
    }))
    .pipe(concat('script.js'))
    .pipe(uglify())
    .pipe(rename({
        extname: '.min.js'
    }))
    .pipe(header(jsHeader))
    .pipe(gulp.dest(docs + 'js/'))
    .pipe(gulp.dest(theme + 'js/'))
    .pipe(gulp.dest(wordpress + 'js/'))
    .pipe(browser.reload({stream:true}))
});



/* img
--------------------*/
gulp.task('img', function(){
  // public
  gulp.src(src + publicImg + '**/*.{png,jpg,gif,svg}', {base: src + img})
    .pipe(imagemin([
      pngquant({ quality: '90-98', speed: 1 }),
      jpegtran(),
      imagemin.svgo(),
      imagemin.gifsicle()
    ]))
    .pipe(gulp.dest(docs + img))
    .pipe(gulp.dest(theme + img))
    .pipe(gulp.dest(wordpress + img))
  // private
  gulp.src(src + privateImg + '**/*.{png,jpg,gif,svg}', {base:  src + img})
    .pipe(imagemin([
      pngquant({ quality: '90-98', speed: 1 }),
      jpegtran(),
      imagemin.svgo(),
      imagemin.gifsicle()
    ]))
    .pipe(gulp.dest(docs + img))
    .pipe(gulp.dest(wordpress + img))
});



/* output
--------------------*/
gulp.task('default',['server'], function() {
  gulp.watch(demo + '/**/*.html', ['html']);
  gulp.watch(src + '/**/*.php', ['php']);
  gulp.watch(src + '/scss/**/*.scss', ['sass']);
  gulp.watch(src + '/js/**/*.js', ['js']);
  gulp.watch(src + img + '/**/*.{png,jpg,gif,svg}', ['img']);
});



/* deploy
--------------------*/
gulp.task('gp', function() {
  return gulp.src('./docs/**/*')
    .pipe(ghPages());
});


/* all
--------------------*/
gulp.task('all', ['license', 'html', 'php', 'sass', 'js', 'img']);
