const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

// بررسی محیط (توسعه یا تولید)
const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
    mode: isProduction ? 'production' : 'development', // حالت تولید یا توسعه
    entry: {
        main: './assets/js/scripts.js', // اسکریپت اصلی سایت
        admin: './assets/js/admin-scripts.js', // اسکریپت مدیریت وردپرس
        styles: './assets/css/custom.css', // استایل‌های اصلی قالب
    },
    output: {
        path: path.resolve(__dirname, 'dist'), // مسیر خروجی فایل‌های بیلد شده
        filename: 'js/[name].min.js', // نام فایل‌های خروجی جاوااسکریپت
        assetModuleFilename: 'assets/[name][ext]', // ساختار نام فایل‌های استاتیک (تصویر، فونت و...)
    },
    module: {
        rules: [
            // پردازش فایل‌های جاوااسکریپت
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
            // پردازش فایل‌های CSS
            {
                test: /\.css$/,
                use: [MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader'],
            },
            // پردازش فایل‌های SCSS/SASS (در صورت نیاز)
            {
                test: /\.scss$/,
                use: [MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader', 'sass-loader'],
            },
            // پردازش فونت‌ها
            {
                test: /\.(woff2?|ttf|eot|svg)$/,
                type: 'asset/resource',
                generator: {
                    filename: 'fonts/[name][ext]',
                },
            },
            // پردازش تصاویر
            {
                test: /\.(png|jpe?g|gif|webp)$/,
                type: 'asset/resource',
                generator: {
                    filename: 'images/[name][ext]',
                },
            },
        ],
    },
    plugins: [
        new CleanWebpackPlugin(), // پاک کردن `dist/` قبل از بیلد جدید
        new MiniCssExtractPlugin({
            filename: 'css/[name].min.css', // خروجی فایل‌های CSS
        }),
    ],
    optimization: {
        minimize: isProduction, // فشرده‌سازی فقط در حالت تولید
        minimizer: [new TerserPlugin(), new CssMinimizerPlugin()], // فشرده‌سازی JS و CSS
    },
    devtool: isProduction ? 'source-map' : 'eval-source-map', // نقشه منبع برای دیباگ
    watch: !isProduction, // فعال‌سازی watch در حالت توسعه
};
