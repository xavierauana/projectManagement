/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('my-table', require('./components/MyTable.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
                      el     : '#app',
                      mounted() {
                        // Toggle the side navigation
                        $("#sidebarToggle, #sidebarToggleTop").on('click', e => {
                          $("body").toggleClass("sidebar-toggled")
                          $(".sidebar").toggleClass("toggled")
                          if ($(".sidebar").hasClass("toggled")) {
                            $('.sidebar .collapse').collapse('hide')
                          }
                        });

                        // Close any open menu accordions when window is resized below 768px
                        $(window).resize(() => {
                          if ($(window).width() < 768) {
                            $('.sidebar .collapse').collapse('hide');
                          }
                        });

                        // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
                        $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', e => {
                          if ($(window).width() > 768) {
                            e.preventDefault();
                            var e0    = e.originalEvent,
                                delta = e0.wheelDelta || -e0.detail
                            this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                          }
                        });

                        // Scroll to top button appear
                        $(document).on('scroll', () => {
                          const scrollDistance = $(this).scrollTop();
                          scrollDistance > 100 ? $('.scroll-to-top').fadeIn()
                                               : $('.scroll-to-top').fadeOut()
                        });

                        // Smooth scrolling using jQuery easing
                        $(document).on('click', 'a.scroll-to-top', e => {
                          e.preventDefault();
                          var $anchor = $(this);
                          $('html, body').stop()
                                         .animate({
                                                    scrollTop: ($($anchor.attr('href')).offset().top)
                                                  }, 1000, 'easeInOutExpo');

                        });


                      },
                      methods: {
                        initDataTable(jqEl, options = {}) {
                          jqEl.DataTable(options)
                        }
                      }

                    });
