// Dark mode
(function() {
  var themeMode = (typeof window.__ONCE_THEME_MODE__ === 'string') ? window.__ONCE_THEME_MODE__ : 'auto';
  if (themeMode !== "auto" && themeMode !== "light" && themeMode !== "dark") themeMode = "auto";

  var autoTimerId = null;

  function isDaytime() {
    var now = new Date();
    var hour = now.getHours();
    return hour >= 6 && hour < 18;
  }

  function getSavedMode() {
    try { return localStorage.getItem("isDarkMode"); } catch (e) { return null; }
  }

  function setSavedMode(mode) {
    try { localStorage.setItem("isDarkMode", mode); } catch (e) {}
  }

  function clearAutoTimer() {
    if (autoTimerId) {
      clearTimeout(autoTimerId);
      autoTimerId = null;
    }
  }

  function setDarkClass(isDark) {
    if (isDark) document.documentElement.classList.add("dark");
    else document.documentElement.classList.remove("dark");
  }

  function getNextChangeTime() {
    var now = new Date();
    var next = new Date();

    if (isDaytime()) {
      next.setHours(18, 0, 0, 0);
    } else {
      next.setHours(6, 0, 0, 0);
      if (next <= now) next.setDate(next.getDate() + 1);
    }

    var delay = next.getTime() - now.getTime();
    return delay > 0 ? delay : 1000;
  }

  function scheduleNextChange() {
    clearAutoTimer();
    autoTimerId = setTimeout(function() {
      if (!getSavedMode()) {
        setDarkClass(!isDaytime());
        scheduleNextChange();
      }
    }, getNextChangeTime());
  }

  function applyInitialMode() {
    var savedMode = getSavedMode();
    if (savedMode === "1") {
      setDarkClass(true);
      clearAutoTimer();
      return;
    }
    if (savedMode === "0") {
      setDarkClass(false);
      clearAutoTimer();
      return;
    }

    if (themeMode === "dark") {
      setDarkClass(true);
      clearAutoTimer();
      return;
    }
    if (themeMode === "light") {
      setDarkClass(false);
      clearAutoTimer();
      return;
    }

    // auto
    setDarkClass(!isDaytime());
    scheduleNextChange();
  }

  window.switchDarkMode = function() {
    var savedMode = getSavedMode();
    var hasDarkClass = document.documentElement.classList.contains("dark");
    if (savedMode === "1" || (savedMode !== "0" && hasDarkClass)) {
      setSavedMode("0");
      setDarkClass(false);
      clearAutoTimer();
    } else {
      setSavedMode("1");
      setDarkClass(true);
      clearAutoTimer();
    }
  };

  window.resetDarkMode = function() {
    try { localStorage.removeItem("isDarkMode"); } catch (e) {}
    applyInitialMode();
  };

  applyInitialMode();
})();

function onceInitCodeBlocks(root) {
  if (!root) root = document;
  var codeBlocks = root.querySelectorAll('.wznrys pre > code, .comment-content pre > code');
  for (var i = 0; i < codeBlocks.length; i++) {
    var codeEl = codeBlocks[i];
    if (codeEl.dataset && codeEl.dataset.lang) continue;

    var codeClassName = (codeEl.getAttribute('class') || '').trim();
    var preClassName = (codeEl.parentElement && codeEl.parentElement.tagName === 'PRE')
      ? (codeEl.parentElement.getAttribute('class') || '').trim()
      : '';

    var match =
      codeClassName.match(/(?:^|\s)(?:language|lang)-([a-z0-9_+-]+)/i) ||
      preClassName.match(/(?:^|\s)(?:language|lang)-([a-z0-9_+-]+)/i);

    if (!match) continue;
    codeEl.setAttribute('data-lang', match[1]);
  }

  // Add copy button for code blocks
  var preBlocks = root.querySelectorAll('.wznrys pre, .comment-content pre');
  for (var j = 0; j < preBlocks.length; j++) {
    var preEl = preBlocks[j];
    if (preEl.querySelector('.once-copy-btn')) continue;

    var codeChild = preEl.querySelector('code');
    if (!codeChild) continue;

    var btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'once-copy-btn';
    btn.setAttribute('aria-label', '复制代码');
    btn.textContent = '复制';

    btn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();

      var button = this;
      var pre = button.parentNode;
      var code = pre ? pre.querySelector('code') : null;
      if (!code) return;

      var text = '';
      var codeCells = code.querySelectorAll('td.hljs-ln-code');
      if (codeCells && codeCells.length) {
        var lines = [];
        for (var k = 0; k < codeCells.length; k++) {
          lines.push(codeCells[k].textContent || '');
        }
        text = lines.join('\n');
      } else {
        text = code.textContent || '';
      }

      // Normalize line endings and trim trailing newlines
      text = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n').replace(/\n+$/, '');

      function setCopiedState(ok) {
        var old = button.textContent;
        button.textContent = ok ? '已复制' : '复制失败';
        setTimeout(function() { button.textContent = old; }, 1200);
      }

      function fallbackCopy(value) {
        var textarea = document.createElement('textarea');
        textarea.value = value;
        textarea.setAttribute('readonly', 'readonly');
        textarea.style.position = 'fixed';
        textarea.style.left = '-9999px';
        textarea.style.top = '0';
        document.body.appendChild(textarea);
        textarea.select();
        try {
          var ok = document.execCommand('copy');
          setCopiedState(!!ok);
        } catch (err) {
          setCopiedState(false);
        }
        document.body.removeChild(textarea);
      }

      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
          setCopiedState(true);
        }).catch(function() {
          fallbackCopy(text);
        });
      } else {
        fallbackCopy(text);
      }
    });

    preEl.appendChild(btn);
  }
}

jQuery(document).ready(function($){
  //table预设calss
  $('.wznrys table, .comment-content table')
    .not('.wznrys pre table')
    .not('.comment-content pre table')
    .addClass("table");
  onceInitCodeBlocks(document);
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
var scrollToTopBtn = document.querySelector(".scrollToTopBtn");
var rootElement = document.documentElement;
function handleScroll() {
  var scrollTotal = rootElement.scrollHeight - rootElement.clientHeight;
  if ((rootElement.scrollTop / scrollTotal) > 0.80) {
    scrollToTopBtn.classList.add("showBtn");
  } else {
    scrollToTopBtn.classList.remove("showBtn");
  }
}
function scrollToTop() {
  if (rootElement.scrollTo) {
    try {
      rootElement.scrollTo({ top: 0, behavior: "smooth" });
      return;
    } catch (e) {}
  }
  rootElement.scrollTop = 0;
}
if (scrollToTopBtn) {
  scrollToTopBtn.addEventListener("click", scrollToTop);
  document.addEventListener("scroll", handleScroll);
}

// 点赞功能
$(document).ready(function(){
  // 检查 Cookie 函数
  function checkLikeCookie(cid) {
      return document.cookie.indexOf('post_like_' + cid) !== -1;
  }

  // 设置 Cookie 函数
  function setLikeCookie(cid) {
      var expires = new Date();
      expires.setHours(23, 59, 59, 999);
      document.cookie = 'post_like_' + cid + '=1; expires=' + expires.toUTCString() + '; path=/';
  }

  // 显示提示消息
  function showToast(message, type) {
      if (typeof type === 'undefined') type = 'info';
      // 创建toast容器（如果不存在）
      if (!$('.toast-container').length) {
          $('body').append('<div class="toast-container"></div>');
      }
      
      // 创建唯一的toast ID
      var toastId = 'toast-' + Date.now();
      
      // 创建toast元素
      var toastHtml = '<div id="' + toastId + '" class="toast ' + type + '">' + message + '</div>';
      
      // 添加toast到容器
      $('.toast-container').append(toastHtml);
      
      // 显示toast（添加show类触发动画）
      setTimeout(function() {
          $('#' + toastId).addClass('show');
      }, 10);
      
      // 3秒后自动隐藏并移除toast
      setTimeout(function() {
          $('#' + toastId).removeClass('show');
          setTimeout(function() {
              $('#' + toastId).remove();
          }, 300);
      }, 3000);
  }

  // 使用事件委托处理点赞
  $(document).on('click', '.specsZan', function(e){
      e.preventDefault();
      var $this = $(this);
      var cid = $this.data('id');
      
      // 检查是否已经点赞
      if(checkLikeCookie(cid)) {
          showToast('请勿重复点赞', 'warning');
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
              if(data === 'already_liked') {
                  showToast('请勿重复点赞', 'warning');
                  // 确保UI状态一致
                  $this.addClass('done');
                  setLikeCookie(cid);
              } else {
                  // 更新点赞数
                  $this.find('.count').text(data);
                  // 添加已点赞状态，但不移除
                  $this.addClass('done');
                  // 设置 Cookie
                  setLikeCookie(cid);
              }
          },
          complete: function(){
              // 移除 loading 状态
              $this.removeClass('loading');
          },
          error: function() {
              showToast('点赞失败，请重试', 'error');
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
var oncePrefetchState = {
  url: null,
  html: null,
  xhr: null,
  timerId: null
};

function oncePrefetchClear() {
  if (oncePrefetchState.timerId) {
    clearTimeout(oncePrefetchState.timerId);
    oncePrefetchState.timerId = null;
  }
  if (oncePrefetchState.xhr && oncePrefetchState.xhr.abort) {
    try { oncePrefetchState.xhr.abort(); } catch (e) {}
  }
  oncePrefetchState.xhr = null;
  oncePrefetchState.html = null;
  oncePrefetchState.url = null;
}

function oncePrefetchStart(url) {
  if (!url) return;
  if (oncePrefetchState.url === url && (oncePrefetchState.html || oncePrefetchState.xhr)) return;

  if (oncePrefetchState.xhr && oncePrefetchState.xhr.abort) {
    try { oncePrefetchState.xhr.abort(); } catch (e) {}
  }

  oncePrefetchState.url = url;
  oncePrefetchState.html = null;

  var jsonUrl = onceToJsonUrl(url);

  oncePrefetchState.xhr = $.ajax({
    url: jsonUrl,
    type: 'GET',
    dataType: 'json'
  }).done(function(data) {
    if (oncePrefetchState.url === url) {
      oncePrefetchState.html = data;
    }
  }).fail(function() {
    if (oncePrefetchState.url !== url) return;
    // Fallback to HTML
    oncePrefetchState.xhr = $.ajax({
      url: url,
      type: 'GET',
      dataType: 'html'
    }).done(function(data) {
      if (oncePrefetchState.url === url) {
        oncePrefetchState.html = data;
      }
    });
  }).always(function() {
    if (oncePrefetchState.url === url) {
      oncePrefetchState.xhr = null;
    }
  });
}

function oncePrefetchSchedule(url, delay) {
  if (!url) return;
  if (typeof delay === 'undefined') delay = 600;

  if (oncePrefetchState.timerId) clearTimeout(oncePrefetchState.timerId);
  oncePrefetchState.timerId = setTimeout(function() {
    oncePrefetchState.timerId = null;
    oncePrefetchStart(url);
  }, delay);
}

function onceConsumePrefetch(url, onSuccess, onError) {
  if (oncePrefetchState.url !== url) return false;

  if (oncePrefetchState.html) {
    var html = oncePrefetchState.html;
    oncePrefetchState.html = null;
    onSuccess(html);
    return true;
  }

  if (oncePrefetchState.xhr) {
    oncePrefetchState.xhr.done(function(data) {
      onSuccess(data);
    }).fail(function(xhr, status, error) {
      if (typeof onError === 'function') onError(xhr, status, error);
    });
    return true;
  }

  return false;
}

function onceToJsonUrl(url) {
  if (!url) return url;
  if (url.indexOf('once_json=1') !== -1) return url;
  return url + (url.indexOf('?') === -1 ? '?' : '&') + 'once_json=1';
}

function onceAppendNextPageHtml(data, $btn) {
  var $html = $('<div></div>').html(data);
  var $newPosts = $html.find('.post_loop');
  var $newBtn = $html.find('.post-read-more a');

  if ($newPosts.length > 0) {
    $('.post_box').append($newPosts);
    $newPosts.hide().fadeIn(300);
    $newPosts.each(function() { onceInitCodeBlocks(this); });
  }

  if ($newBtn.length > 0) {
    var nextHref = $newBtn.attr('href');
    $btn.attr('href', nextHref)
       .removeClass('loading')
       .text('加载更多');

    // Prefetch the following page after updating href
    oncePrefetchSchedule(nextHref, 800);
  } else {
    $('.post-read-more').remove();
    oncePrefetchClear();
  }
}

function onceAppendNextPageJson(payload, $btn) {
  if (!payload || typeof payload !== 'object') return false;
  var postsHtml = payload.html || '';
  var nextHref = payload.next || null;

  var $wrap = $('<div></div>').html(postsHtml);
  var $newPosts = $wrap.children();
  if ($newPosts.length > 0) {
    $('.post_box').append($newPosts);
    $newPosts.hide().fadeIn(300);
    $newPosts.each(function() { onceInitCodeBlocks(this); });
  }

  if (nextHref) {
    $btn.attr('href', nextHref)
       .removeClass('loading')
       .text('加载更多');
    oncePrefetchSchedule(nextHref, 800);
  } else {
    $('.post-read-more').remove();
    oncePrefetchClear();
  }

  return true;
}

$(document).on('click', '.post-read-more a', function(e){
    e.preventDefault();
    var $btn = $(this);
    var nextPage = $btn.attr('href');
    
    if($btn.hasClass('loading')) return false;
    
    $btn.addClass('loading').text('加载中...');

    var usedPrefetch = onceConsumePrefetch(nextPage, function(payload) {
      if (payload && typeof payload === 'object') {
        onceAppendNextPageJson(payload, $btn);
      } else {
        onceAppendNextPageHtml(payload, $btn);
      }
    }, function(xhr, status, error) {
      console.error("AJAX Error:", status, error);
      $btn.removeClass('loading').text('加载失败，点击重试');
    });

    if (!usedPrefetch) {
      $.ajax({
          url: onceToJsonUrl(nextPage),
          type: 'GET',
          dataType: 'json',
          success: function(data){
              if (!onceAppendNextPageJson(data, $btn)) {
                $btn.removeClass('loading').text('加载失败，点击重试');
              }
          },
          error: function() {
              // Fallback to HTML
              $.ajax({
                url: nextPage,
                type: 'GET',
                dataType: 'html',
                success: function(html) {
                  onceAppendNextPageHtml(html, $btn);
                },
                error: function(xhr, status, error) {
                  console.error("AJAX Error:", status, error);
                  $btn.removeClass('loading').text('加载失败，点击重试');
                }
              });
          }
      });
    }
    
    return false;
});

// Prefetch next page to make "加载更多" feel instant
$(document).on('mouseenter touchstart', '.post-read-more a', function() {
  var href = $(this).attr('href');
  oncePrefetchSchedule(href, 150);
});

$(document).ready(function() {
  var $btn = $('.post-read-more a').first();
  if ($btn.length) {
    oncePrefetchSchedule($btn.attr('href'), 1200);

    if ('IntersectionObserver' in window) {
      try {
        var io = new IntersectionObserver(function(entries) {
          for (var i = 0; i < entries.length; i++) {
            if (entries[i].isIntersecting) {
              oncePrefetchSchedule($btn.attr('href'), 100);
              break;
            }
          }
        }, { rootMargin: '600px 0px' });
        io.observe($btn.get(0));
      } catch (e) {}
    }
  }
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
    var lazyloadImages = document.querySelectorAll('.lazyload');
    var imageObserver = null;
    
    // 检查浏览器是否支持IntersectionObserver
    if ("IntersectionObserver" in window) {
        imageObserver = new IntersectionObserver(function(entries, observer) {
            for (var i = 0; i < entries.length; i++) {
                var entry = entries[i];
                if (entry.isIntersecting) {
                    var image = entry.target;
                    if (image.dataset && image.dataset.src) {
                        image.src = image.dataset.src;
                    }
                    image.classList.remove("lazyload");
                    imageObserver.unobserve(image);
                }
            }
        });

        for (var j = 0; j < lazyloadImages.length; j++) {
            imageObserver.observe(lazyloadImages[j]);
        }
    } else {
        // 降级处理：滚动事件监听
        var lazyloadThrottleTimeout;
        
        function lazyload() {
            if (lazyloadThrottleTimeout) {
                clearTimeout(lazyloadThrottleTimeout);
            }
            
            lazyloadThrottleTimeout = setTimeout(function() {
                var scrollTop = window.pageYOffset;
                
                for (var k = 0; k < lazyloadImages.length; k++) {
                    var img = lazyloadImages[k];
                    if (img.offsetTop < (window.innerHeight + scrollTop)) {
                        if (img.dataset && img.dataset.src) {
                            img.src = img.dataset.src;
                        }
                        img.classList.remove('lazyload');
                    }
                }
                
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
            var newLazyImages = document.querySelectorAll('.lazyload');
            if ("IntersectionObserver" in window && imageObserver) {
                for (var idx = 0; idx < newLazyImages.length; idx++) {
                    var newImg = newLazyImages[idx];
                    if (!newImg.classList.contains('observed')) {
                        imageObserver.observe(newImg);
                        newImg.classList.add('observed');
                    }
                }
            } else {
                // 触发一次lazyload函数
                if (typeof lazyload === 'function') {
                    lazyload();
                }
            }
        }, 500); // 延迟执行，确保DOM已经更新
    });
});
