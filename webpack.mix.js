const mix = require('laravel-mix');
 
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
 
mix.js('resources/js/app.js', 'public/js')
.css('resources/css/navigation.css', 'public/css')
.css('resources/css/clock.css', 'public/css')
.js('resources/js/clock.js', 'public/js')
.css('resources/css/loading.css', 'public/css')
.js('resources/js/loading.js', 'public/js')
.js('resources/js/punch_begin.js', 'public/js')
.js('resources/js/punch_finish_tab.js', 'public/js')
.css('resources/css/punch_finish_tab.css', 'public/css')
.js('resources/js/punch_menu.js', 'public/js')
.js('resources/js/punch_finish.js', 'public/js')
.js('resources/js/punch_finish_input.js', 'public/js')
.js('resources/js/punch_complete_popup.js', 'public/js')
.css('resources/css/punch_complete_popup.css', 'public/css')
.js('resources/js/punch_common.js', 'public/js')
.css('resources/css/theme_color.css', 'public/css')
.js('resources/js/kintai_list.js', 'public/js')
.js('resources/js/kintai_detail.js', 'public/js')
.js('resources/js/tr_link.js', 'public/js')
.css('resources/css/radio_btn.css', 'public/css')
.css('resources/css/kintai_report_output.css', 'public/css')
.js('resources/js/employee_detail.js', 'public/js')
.js('resources/js/tag_detail.js', 'public/js')
.autoload({
    jquery: ['$', 'window.jQuery']
})
.postCss('resources/css/app.css', 'public/css', 
    [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]
);