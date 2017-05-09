/**
 * Created by ksenkso on 08.05.17.
 */
jQuery(function ($) {
   var $menu = $('.cat-list');
   $menu.find('.cat-toggle').on('click', function (e) {
       e.preventDefault();
       $(this).toggleClass('active').parent().next().slideToggle();
   })
});