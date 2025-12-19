// 轮播图实现
class Carousel {
    constructor(element, options = {}) {
        this.container = element;
        this.items = element.querySelectorAll('.carousel-item');
        this.total = this.items.length;
        this.current = 0;
        this.options = {
            interval: options.interval || 5000,
            duration: options.duration || 600
        };
        this.init();
    }
    init() {
        // 初始化显示第一个
        this.items[0].classList.add('active');
        // 自动播放
        if (this.total > 1) {
            this.autoplay();
            // 绑定事件
            this.bindEvents();
        }
    }
    next() {
        let next = (this.current + 1) % this.total;
        this.slideTo(next);
    }
    prev() {
        let prev = (this.current - 1 + this.total) % this.total;
        this.slideTo(prev);
    }
    slideTo(index) {
        if (index === this.current) return;        
        // 移除当前活动项的active类
        this.items[this.current].classList.remove('active');       
        // 添加新活动项的active类
        this.items[index].classList.add('active');     
        // 更新指示器
        if (this.indicators) {
            this.indicators[this.current].classList.remove('active');
            this.indicators[index].classList.add('active');
        }      
        this.current = index;
    }  
    autoplay() {
        this.timer = setInterval(() => {
            this.next();
        }, this.options.interval);
    }   
    stop() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }   
    bindEvents() {
        // 鼠标悬停暂停
        this.container.addEventListener('mouseenter', () => this.stop());
        this.container.addEventListener('mouseleave', () => this.autoplay());    
        // 绑定按钮事件
        const prevBtn = this.container.querySelector('.carousel-control-prev');
        const nextBtn = this.container.querySelector('.carousel-control-next');   
        if (prevBtn) {
            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.prev();
            });
        }    
        if (nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.next();
            });
        }
        // 绑定指示器事件
        this.indicators = this.container.querySelectorAll('.carousel-indicators button');
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                this.slideTo(index);
            });
        });    
        // 触摸事件支持
        let startX = 0;
        let endX = 0;
        this.container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            this.stop();
        }, { passive: true });  
        this.container.addEventListener('touchmove', (e) => {
            endX = e.touches[0].clientX;
        }, { passive: true }); 
        this.container.addEventListener('touchend', () => {
            let diff = startX - endX;
            if (Math.abs(diff) > 50) { // 最小滑动距离
                if (diff > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
            this.autoplay();
        });
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('#banner');
    if (carousel) {
        new Carousel(carousel, {
            interval: 5000, // 自动播放间隔，单位毫秒
            duration: 600  // 动画持续时间，单位毫秒
        });
    }
});