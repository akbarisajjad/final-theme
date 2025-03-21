// 🔥 Ultimate Gulp Configuration for Seokar Theme  
const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const purgecss = require('gulp-purgecss');
const terser = require('gulp-terser');
const imagemin = require('gulp-imagemin');
const webp = require('gulp-webp');
const babel = require('gulp-babel');
const eslint = require('gulp-eslint');
const stylelint = require('gulp-stylelint');
const htmlmin = require('gulp-htmlmin');
const gzip = require('gulp-gzip');
const brotli = require('gulp-brotli');
const browserSync = require('browser-sync').create();
const sourcemaps = require('gulp-sourcemaps');
const del = require('del');
const gulpIf = require('gulp-if');

// 🔹 مسیرهای فایل‌ها
const paths = {
    styles: {
        src: 'src/scss/**/*.scss',
        dest: 'assets/css/'
    },
    scripts: {
        src: 'src/js/**/*.js',
        dest: 'assets/js/'
    },
    images: {
        src: 'src/images/**/*.{png,jpg,jpeg,gif,svg,webp}',
        dest: 'assets/images/'
    },
    webpImages: {
        src: 'src/images/**/*.{png,jpg,jpeg}',
        dest: 'assets/images/webp/'
    },
    fonts: {
        src: 'src/fonts/**/*.{woff,woff2,ttf,eot,otf}',
        dest: 'assets/fonts/'
    },
    html: {
        src: 'src/**/*.html',
        dest: 'assets/'
    }
};

// 🔥 بررسی محیط (توسعه یا تولید)
const isProduction = process.env.NODE_ENV === 'production';

// 🏗️ **وظیفه: کامپایل و بهینه‌سازی SCSS به CSS**
function styles() {
    return src(paths.styles.src)
        .pipe(gulpIf(!isProduction, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(gulpIf(isProduction, purgecss({ content: ['**/*.php', '**/*.html', '**/*.js'] })))
        .pipe(gulpIf(!isProduction, sourcemaps.write('.')))
        .pipe(dest(paths.styles.dest))
        .pipe(browserSync.stream());
}

// ⚡ **وظیفه: فشرده‌سازی و بهینه‌سازی JavaScript**
function scripts() {
    return src(paths.scripts.src)
        .pipe(eslint())
        .pipe(eslint.format())
        .pipe(gulpIf(!isProduction, sourcemaps.init()))
        .pipe(babel({ presets: ['@babel/env'] }))
        .pipe(terser())
        .pipe(gulpIf(!isProduction, sourcemaps.write('.')))
        .pipe(dest(paths.scripts.dest))
        .pipe(browserSync.stream());
}

// 📷 **وظیفه: فشرده‌سازی تصاویر**
function images() {
    return src(paths.images.src)
        .pipe(imagemin([
            imagemin.mozjpeg({ quality: 80, progressive: true }),
            imagemin.optipng({ optimizationLevel: 5 }),
            imagemin.svgo({ plugins: [{ removeViewBox: false }] })
        ]))
        .pipe(dest(paths.images.dest));
}

// 🖼️ **وظیفه: تبدیل تصاویر به WebP**
function convertToWebp() {
    return src(paths.webpImages.src)
        .pipe(webp({ quality: 80 }))
        .pipe(dest(paths.webpImages.dest));
}

// 🔤 **وظیفه: کپی کردن فونت‌ها**
function fonts() {
    return src(paths.fonts.src)
        .pipe(dest(paths.fonts.dest));
}

// 🛠 **وظیفه: حذف فایل‌های کش و اضافی**
function clean() {
    return del(['assets/**/*']);
}

// 🌐 **وظیفه: راه‌اندازی Live Reload با BrowserSync**
function serve() {
    browserSync.init({
        proxy: 'http://localhost:8000',
        files: ['**/*.php'],
        open: false,
        notify: false
    });

    watch(paths.styles.src, styles);
    watch(paths.scripts.src, scripts);
    watch(paths.images.src, images);
    watch(paths.fonts.src, fonts);
}

// 📝 **وظیفه: فشرده‌سازی HTML**
function html() {
    return src(paths.html.src)
        .pipe(htmlmin({ collapseWhitespace: true, removeComments: true }))
        .pipe(dest(paths.html.dest));
}

// 🚀 **وظیفه: فشرده‌سازی Gzip & Brotli برای بهینه‌سازی سرور**
function compress() {
    return src(['assets/css/*.css', 'assets/js/*.js', 'assets/**/*.html'])
        .pipe(gzip())
        .pipe(dest('assets/'))
        .pipe(brotli.compress({ quality: 11 }))
        .pipe(dest('assets/'));
}

// 🚀 **وظایف اصلی**
exports.clean = clean;
exports.styles = styles;
exports.scripts = scripts;
exports.images = images;
exports.fonts = fonts;
exports.convertToWebp = convertToWebp;
exports.html = html;
exports.serve = serve;
exports.compress = compress;
exports.build = series(clean, parallel(styles, scripts, images, fonts, convertToWebp, html), compress);
exports.default = series(exports.build, serve);
