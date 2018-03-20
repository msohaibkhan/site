/*!
 * 
 * Fiercely quick and opinionated front-ends
 * https://HosseinKarami.github.io/fastshell
 * @author Hossein Karami
 * @version 1.0.5
 * Copyright 2016. MIT licensed.
 */
(function ($, window, document, undefined) {
    'use strict';
    $(function () {
        jQuery(document).ready(function () {
            var screenHeight = jQuery(document).height();
            var screenWidth = jQuery(window).width();
			var $rtl = false;
			if (jQuery("html").attr("dir") == 'rtl'){
				$rtl = true;
			}
			if (jQuery('#siteorigin-panels-grids-wp_footer').length){
				var siteorigin_css_footer = jQuery('#siteorigin-panels-grids-wp_footer').remove();
				siteorigin_css_footer.appendTo('head');
			}
            jQuery('.education-search-category').chosen();
            jQuery('[data-countdown]').each(function () {
                var $this = jQuery(this), finalDate = jQuery(this).data('countdown');
                $this.countdown(finalDate, function (event) {
                    $this.find('.education-days > span').html(event.strftime('%D'));
                    $this.find('.education-hours > span').html(event.strftime('%H'));
                    $this.find('.education-mins > span').html(event.strftime('%M'));
                    $this.find('.education-secs > span').html(event.strftime('%S'));
                });
            });
            jQuery('.gallery-items, .gallery-link-file .gallery-icon > a').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
            if (typeof sfwd_courses !== "undefined" && sfwd_courses){
                if(sfwd_courses.course_id){
                    jQuery('body').on('click','#education_'+sfwd_courses.course_id+'_expand',function(){
                        jQuery('#learndash_post_'+sfwd_courses.course_id+' .learndash_topic_dots').slideDown();
                        return false;
                    });
                    jQuery('body').on('click','#education_'+sfwd_courses.course_id+'_collapse',function(){
                        jQuery('#learndash_post_'+sfwd_courses.course_id+' .learndash_topic_dots').slideUp();
                        return false;
                    });
                }
            }
            if (jQuery('.wpcr3_review_form_text_field input').length) {
                jQuery('.wpcr3_review_form_text_field input').each(function () {
                    jQuery(this).parents('.wpcr3_review_form_text_field').eq(0).addClass(jQuery(this).attr('id'));
                });
            }
            jQuery('.education-count').each(function () {
                jQuery(this).counterUp();
            });
            if (jQuery('.owl-carousel.owl-loaded').length){
                jQuery('.owl-carousel.owl-loaded').each(function () {
                    jQuery(this).trigger('refresh.owl.carousel');
                });
            }
            function trustView(elem) {
                if (jQuery(elem).length) {
                    var bottomOfObject = jQuery(elem).offset().top;
                    var bottomOfWindow = jQuery(window).scrollTop() + jQuery(window).height();
                    if (bottomOfWindow > bottomOfObject) {
                        return true;
                    }
                }
            }
            function addClassView(addClass, elem) {
                if (trustView(elem) === true) {
                    jQuery(addClass).addClass('inview');
                }
            }
            jQuery(window).on('scroll', function () {
                addClassView('#new-products .nbtsow-wcproducts', '#new-products .nbtsow-wcproducts');
                addClassView('.nbtsow-blog-posts', '.nbtsow-blog-posts');
                addClassView('.nbtsow-members', '.nbtsow-members');
                addClassView('.nbtsow-collection', '.nbtsow-collection');
            });
            function menuPosition() {
                if (jQuery('#main-menu .mega-sub-menu').length) {
                    jQuery('#main-menu .mega-sub-menu').each(function () {
                        jQuery(this).removeAttr("style");
                        var $containerWidth = jQuery("body").outerWidth();
                        var $menuwidth = jQuery(this).outerWidth();
                        if ($menuwidth > $containerWidth) {
                            jQuery(this).css({
                                'width': ($containerWidth - 20) + 'px'
                            }).offset({
                                'left': 10
                            });
                        } else {
                            var $parentleft = jQuery(this).parent().offset().left;
                            var $parentright = jQuery(this).parent().offset().left + jQuery(this).parent().outerWidth();
                            if (jQuery(this).parents('.mega-sub-menu').length) {
								var $menuleft = $parentleft - jQuery(this).outerWidth();
                                var $menuright = $parentright + jQuery(this).outerWidth();
								if ($rtl){
									if ($menuleft < 0) {
										if ($menuright > $containerWidth) {
											if ($parentleft > ($containerWidth - $parentright)) {
												jQuery(this).css({
													'width': $parentleft + 'px',
													'left': 'auto',
													'right': '100%'
												});
											} else {
												jQuery(this).css({
													'width': ($containerWidth - $parentright) + 'px',
													'left': '100%'
												});
											}
										} else {
											jQuery(this).offset({
												'left': $parentright
											});
										}
									} else {
										jQuery(this).css({
											'left': '-100%'
										});
									}
								} else {
									if ($menuright > $containerWidth) {
										if ($menuleft < 0) {
											if ($parentleft > ($containerWidth - $parentright)) {
												jQuery(this).css({
													'width': $parentleft + 'px',
													'left': 'auto',
													'right': '100%'
												});
											} else {
												jQuery(this).css({
													'width': ($containerWidth - $parentright) + 'px',
													'left': '100%'
												});
											}
										} else {
											jQuery(this).offset({
												'left': $menuleft
											});
										}
									} else {
										jQuery(this).css({
											'left': '100%'
										});
									}
								}
                            } else {
								var $menuleft = $parentright - jQuery(this).outerWidth();
                                var $menuright = $parentleft + jQuery(this).outerWidth();
								if ($rtl){
									if ($menuleft < 0) {
										if ($menuright > $containerWidth) {
											jQuery(this).offset({
												'left': ($containerWidth - $menuwidth) / 2
											});
										} else {
											jQuery(this).offset({
												'left': $parentleft
											});
										}
									} else {
										jQuery(this).offset({
											'left': $menuleft
										});
									}
								} else {
									if ($menuright > $containerWidth) {
										if ($menuleft < 0) {
											jQuery(this).offset({
												'left': ($containerWidth - $menuwidth) / 2
											});
										} else {
											jQuery(this).offset({
												'left': $menuleft
											});
										}
									} else {
										jQuery(this).offset({
											'left': $parentleft
										});
									}
								}
                            }
                        }
                    });
                } else if (jQuery('#main-menu ul.sub-menu').length) {
                    jQuery('#main-menu ul.sub-menu').each(function () {
						jQuery(this).removeAttr("style");
                        var $containerWidth = jQuery("body").outerWidth();
                        var $menuwidth = jQuery(this).outerWidth();
                        var $parentleft = jQuery(this).parent().offset().left;
                        var $parentright = jQuery(this).parent().offset().left + jQuery(this).parent().outerWidth();
                        if (jQuery(this).parents('.sub-menu').length) {
							var $menuleft = $parentleft - jQuery(this).outerWidth();
                            var $menuright = $parentright + jQuery(this).outerWidth();
							if ($rtl){
								if ($menuleft < 0) {
									if ($menuright > $containerWidth) {
										if ($parentleft > ($containerWidth - $parentright)) {
											jQuery(this).css({
												'width': $parentleft + 'px',
												'left': 'auto',
												'right': '100%'
											});
										} else {
											jQuery(this).css({
												'width': ($containerWidth - $parentright) + 'px',
												'left': '100%',
												'right': 'auto'
											});
										}
									} else {
										jQuery(this).css({
											'left': '100%',
											'right': 'auto'
										});
									}
								} else {
									jQuery(this).css({
										'left': '-100%'
									});
								}
							} else {
								if ($menuright > $containerWidth) {
									if ($menuleft < 0) {
										if ($parentleft > ($containerWidth - $parentright)) {
											jQuery(this).css({
												'width': $parentleft + 'px',
												'left': 'auto',
												'right': '100%'
											});
										} else {
											jQuery(this).css({
												'width': ($containerWidth - $parentright) + 'px',
												'left': '100%',
												'right': 'auto'
											});
										}
									} else {
										jQuery(this).offset({
											'left': $menuleft
										});
									}
								} else {
									jQuery(this).css({
										'left': '100%'
									});
								}
							}
                        } else {
							var $menuleft = $parentright - jQuery(this).outerWidth();
                            var $menuright = $parentleft + jQuery(this).outerWidth();
							if ($rtl){
								if ($menuleft < 0) {
									if ($menuright > $containerWidth) {
										jQuery(this).offset({
											'left': ($containerWidth - $menuwidth) / 2
										});
									} else {
										jQuery(this).offset({
											'left': $parentleft
										});
									}
								} else {
									jQuery(this).offset({
										'left': $menuleft
									});
								}
							} else {
								if ($menuright > $containerWidth) {
									if ($menuleft < 0) {
										jQuery(this).offset({
											'left': ($containerWidth - $menuwidth) / 2
										});
									} else {
										jQuery(this).offset({
											'left': $menuleft
										});
									}
								} else {
									jQuery(this).offset({
										'left': $parentleft
									});
								}
							}
                        }
                    });
                }
            }
            function menuShow() {
				if ($rtl){
					jQuery('#main-menu').animate({'right': '0'}, 250);
				} else {
					jQuery('#main-menu').animate({'left': '0'}, 250);
				}
                jQuery('#main-menu').css('display', 'block');
            }
            function menuHide() {
                if ($rtl){
					jQuery('#main-menu').animate({'right': '-100%'}, 250);
				} else {
					jQuery('#main-menu').animate({'left': '-100%'}, 250);
				}
            }
            if (screenWidth < 992) {
                jQuery('#mega-menu-primary').css('height', screenHeight);
                jQuery('.menu-responsive-toggle .nbticon').on('click', function () {
                    menuShow();
                });
                jQuery('.close-mb-menu .nbticon').on('click', function () {
                    menuHide();
                });
                jQuery('#mega-menu-primary .mega-menu-item-has-children').on('click', function () {
                    jQuery(this).toggleClass('open');
                });
                jQuery('#mega-menu-primary .mega-menu-item-has-children > *').on('click', function (e) {
                    e.stopPropagation();
                });
                jQuery('.mega-menu-item .mega-search-wrap > .mega-search').removeClass('mega-search-open').addClass('mega-search-closed');
                jQuery('.mega-menu-item .mega-search-wrap > .mega-search input[type=text]').attr("placeholder", jQuery('.mega-menu-item .mega-search-wrap > .mega-search input[type=text]').attr("data-placeholder"));
            } else {
                menuPosition();
            }
            jQuery(window).on('resize', function () {
                var screenHeight = jQuery(document).height();
                var screenWidth = jQuery(window).width();
                if (screenWidth < 992) {
                    jQuery('.menu-responsive-toggle .nbticon').on('click', function () {
                        menuShow();
                    });
                    jQuery('.close-mb-menu .nbticon').on('click', function () {
                        menuHide();
                    });
                    jQuery('#mega-menu-primary .mega-menu-item-has-children').on('click', function () {
                        jQuery(this).toggleClass('open');
                    });
                    jQuery('#mega-menu-primary .mega-menu-item-has-children > *').on('click', function (e) {
                        e.stopPropagation();
                    });
                    jQuery('.mega-menu-item .mega-search-wrap > .mega-search').removeClass('mega-search-open').addClass('mega-search-closed');
                    jQuery('.mega-menu-item .mega-search-wrap > .mega-search input[type=text]').attr("placeholder", jQuery('.mega-menu-item .mega-search-wrap > .mega-search input[type=text]').attr("data-placeholder"));
                } else {
                    jQuery('#main-menu').removeAttr('style');
                    jQuery('#mega-menu-primary').removeAttr('style');
                    jQuery('#mega-menu-primary .mega-menu-item-has-children').removeClass('open');
                    menuPosition();
                    jQuery('.mega-menu-item .mega-search-wrap > .mega-search input[type=text]').removeAttr("placeholder");
                }
            });
			// TOGGLE COLLAPSE
			function toggleCollapse(e) {
				$(e.target)
					.parents('.panel')
					.toggleClass('active');
			}
			$('body').on('hide.bs.collapse', toggleCollapse);
			$('body').on('show.bs.collapse', toggleCollapse);
        });
    });

})(jQuery, window, document);
