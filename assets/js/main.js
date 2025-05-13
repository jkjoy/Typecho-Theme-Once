// 监听按钮点击
jQuery(document).ready(function($){
  //table预设calss
  $('.wznrys table').addClass("table");
});

$(document).ready(function(){
    //子菜单点击展开
});

//列表ajax加载
jQuery(document).ready(function($) {
});

//导航菜单
function ds_mainmenu(ulclass){
    $(document).ready(function(){
        $(ulclass+' li').hover(function(){
            $(this).children("ul").show();
        },function(){
            $(this).children("ul").hide();
        });
    });
}
ds_mainmenu('.header-menu-ul');

//返回顶部
const scrollToTopBtn = document.querySelector(".scrollToTopBtn")
const rootElement = document.documentElement
function handleScroll() {
  const scrollTotal = rootElement.scrollHeight - rootElement.clientHeight
  if ((rootElement.scrollTop / scrollTotal ) > 0.80 ) {
    scrollToTopBtn.classList.add("showBtn")
  } else {
    scrollToTopBtn.classList.remove("showBtn")
  }
}
function scrollToTop() {
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth"
  })
}
scrollToTopBtn.addEventListener("click", scrollToTop)
document.addEventListener("scroll", handleScroll)

// 点赞功能
$(document).ready(function(){
// 检查 Cookie 函数
function checkLikeCookie(cid) {
    return document.cookie.indexOf('post_like_' + cid) !== -1;
}

// 设置 Cookie 函数
function setLikeCookie(cid) {
    const expires = new Date();
    expires.setHours(23, 59, 59, 999);
    document.cookie = `post_like_${cid}=1; expires=${expires.toUTCString()}; path=/`;
}

// 使用事件委托处理点赞
$(document).on('click', '.specsZan', function(e){
    e.preventDefault();
    var $this = $(this);
    var cid = $this.data('id');
    
    // 检查是否已经点赞
    if(checkLikeCookie(cid)) {
        return false;
    }
    
    // 检查是否正在加载
    if($this.hasClass('loading')) return false;
    
    // 添加加载状态
    $this.addClass('loading');
    
    // 发送点赞请求
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            action: 'specs_zan',
            cid: cid
        },
        success: function(data){
            if(data !== 'already_liked') {
                // 更新点赞数
                $this.find('.count').text(data);
                // 添加已点赞状态，但不移除
                $this.addClass('done');
                // 设置 Cookie
                setLikeCookie(cid);
            }
        },
        complete: function(){
            // 只移除 loading 状态，保持 done 状态
            $this.removeClass('loading');
        }
    });
    
    return false;
});

// 页面加载时检查已点赞状态
$('.specsZan').each(function() {
    var $this = $(this);
    var cid = $this.data('id');
    if(checkLikeCookie(cid)) {
        $this.addClass('done');
    }
});
});

// 加载更多文章
$(document).on('click', '.post-read-more a', function(e){
    e.preventDefault();
    var $btn = $(this);
    var nextPage = $btn.attr('href');
    
    if($btn.hasClass('loading')) return false;
    
    $btn.addClass('loading').text('加载中...');
    
    $.ajax({
        url: nextPage,
        type: 'GET',
        dataType: 'html',
        success: function(data){
            // 创建一个临时的DOM元素来解析返回的HTML
            var $html = $('<div></div>').html(data);
            
            // 找到新的文章
            var $newPosts = $html.find('.post_loop');
            
            // 找到新的"加载更多"按钮
            var $newBtn = $html.find('.post-read-more a');
            
            // 将新文章添加到页面
            if ($newPosts.length > 0) {
                $('.post_box').append($newPosts);
                // 新文章淡入效果
                $newPosts.hide().fadeIn(500);
            }
            
            // 更新"加载更多"按钮或移除它
            if($newBtn.length > 0){
                $btn.attr('href', $newBtn.attr('href'))
                   .removeClass('loading')
                   .text('加载更多');
            } else {
                $('.post-read-more').remove();
            }
        },
        error: function(xhr, status, error){
            console.error("AJAX Error:", status, error);
            $btn.removeClass('loading').text('加载失败，点击重试');
        }
    });
    
    return false;
});

// 确保Bootstrap组件正确初始化
document.addEventListener('DOMContentLoaded', function() {
  // 手动处理菜单按钮点击事件
  var menuButton = document.querySelector('.mobile_an');
  var mobileMenu = document.getElementById('mobile_right_nav');
  
  if (menuButton && mobileMenu) {
    menuButton.addEventListener('click', function() {
      // 如果bootstrap对象存在，使用Bootstrap的API
      if (typeof bootstrap !== 'undefined') {
        var offcanvasInstance = bootstrap.Offcanvas.getInstance(mobileMenu);
        if (offcanvasInstance) {
          offcanvasInstance.show();
        } else {
          var bsOffcanvas = new bootstrap.Offcanvas(mobileMenu);
          bsOffcanvas.show();
        }
      } else {
        // 如果bootstrap对象不存在，使用简单的类切换
        mobileMenu.classList.add('show');
      }
    });
    
    // 处理关闭按钮点击事件
    var closeButton = mobileMenu.querySelector('.btn-close');
    if (closeButton) {
      closeButton.addEventListener('click', function() {
        if (typeof bootstrap !== 'undefined') {
          var offcanvasInstance = bootstrap.Offcanvas.getInstance(mobileMenu);
          if (offcanvasInstance) {
            offcanvasInstance.hide();
          }
        } else {
          mobileMenu.classList.remove('show');
        }
      });
    }
  }
  
  // 处理搜索按钮点击事件
  var searchButton = document.querySelector('.top_r_an[data-bs-target="#c_sousuo"]');
  var searchMenu = document.getElementById('c_sousuo');
  
  if (searchButton && searchMenu) {
    // 创建背景遮罩 (不改变DOM结构，只添加事件监听)
    searchButton.addEventListener('click', function() {
      if (typeof bootstrap !== 'undefined') {
        var offcanvasInstance = bootstrap.Offcanvas.getInstance(searchMenu);
        if (offcanvasInstance) {
          offcanvasInstance.show();
        } else {
          var bsOffcanvas = new bootstrap.Offcanvas(searchMenu);
          bsOffcanvas.show();
        }
      } else {
        // 手动显示搜索框
        searchMenu.classList.add('show');
      }
    });
    
    // 添加关闭搜索框的按钮事件处理
    var closeSearchButtons = searchMenu.querySelectorAll('[data-bs-dismiss="offcanvas"]');
    closeSearchButtons.forEach(function(btn) {
      btn.addEventListener('click', function() {
        if (typeof bootstrap !== 'undefined') {
          var offcanvasInstance = bootstrap.Offcanvas.getInstance(searchMenu);
          if (offcanvasInstance) {
            offcanvasInstance.hide();
          }
        } else {
          searchMenu.classList.remove('show');
        }
      });
    });
    
    // 添加点击搜索框外部区域关闭搜索框的功能
    document.addEventListener('click', function(event) {
      // 如果搜索框已显示，且点击的不是搜索框内部元素，也不是搜索按钮
      if (searchMenu.classList.contains('show') && 
          !searchMenu.contains(event.target) && 
          event.target !== searchButton && 
          !searchButton.contains(event.target)) {
        if (typeof bootstrap !== 'undefined') {
          var offcanvasInstance = bootstrap.Offcanvas.getInstance(searchMenu);
          if (offcanvasInstance) {
            offcanvasInstance.hide();
          }
        } else {
          searchMenu.classList.remove('show');
        }
      }
    });
    
    // 监听ESC键关闭搜索框
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape' && searchMenu.classList.contains('show')) {
        if (typeof bootstrap !== 'undefined') {
          var offcanvasInstance = bootstrap.Offcanvas.getInstance(searchMenu);
          if (offcanvasInstance) {
            offcanvasInstance.hide();
          }
        } else {
          searchMenu.classList.remove('show');
        }
      }
    });
  }
  
  // 确保移动菜单的子菜单展开/收起功能正常工作
  $('.menu-zk .menu-item-has-children').prepend('<span class="czxjcdbs"></span>');
  $('.menu-zk li.menu-item-has-children .czxjcdbs').click(function(){
    $(this).toggleClass("kai");
    $(this).nextAll('.sub-menu').slideToggle("slow");
  });
});

// 懒加载实现
document.addEventListener('DOMContentLoaded', function() {
    // 懒加载初始化
    let lazyloadImages = document.querySelectorAll('.lazyload');
    let imageObserver = null;
    
    // 检查浏览器是否支持IntersectionObserver
    if ("IntersectionObserver" in window) {
        imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    let image = entry.target;
                    if (image.dataset.src) {
                        image.src = image.dataset.src;
                    }
                    image.classList.remove("lazyload");
                    imageObserver.unobserve(image);
                }
            });
        });

        lazyloadImages.forEach(function(image) {
            imageObserver.observe(image);
        });
    } else {
        // 降级处理：滚动事件监听
        let lazyloadThrottleTimeout;
        
        function lazyload() {
            if (lazyloadThrottleTimeout) {
                clearTimeout(lazyloadThrottleTimeout);
            }
            
            lazyloadThrottleTimeout = setTimeout(function() {
                let scrollTop = window.pageYOffset;
                
                lazyloadImages.forEach(function(img) {
                    if (img.offsetTop < (window.innerHeight + scrollTop)) {
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                        }
                        img.classList.remove('lazyload');
                    }
                });
                
                if (lazyloadImages.length == 0) { 
                    document.removeEventListener("scroll", lazyload);
                    window.removeEventListener("resize", lazyload);
                    window.removeEventListener("orientationChange", lazyload);
                }
            }, 20);
        }
        
        document.addEventListener("scroll", lazyload);
        window.addEventListener("resize", lazyload);
        window.addEventListener("orientationChange", lazyload);
        
        // 初始执行一次
        lazyload();
    }
    
    // 处理"加载更多"后的新图片
    $(document).ajaxSuccess(function() {
        setTimeout(function() {
            let newLazyImages = document.querySelectorAll('.lazyload');
            if ("IntersectionObserver" in window && imageObserver) {
                newLazyImages.forEach(function(image) {
                    if (!image.classList.contains('observed')) {
                        imageObserver.observe(image);
                        image.classList.add('observed');
                    }
                });
            } else {
                // 触发一次lazyload函数
                if (typeof lazyload === 'function') {
                    lazyload();
                }
            }
        }, 500); // 延迟执行，确保DOM已经更新
    });
});