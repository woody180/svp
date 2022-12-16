import SketchEngine from '../sketchEngine/SketchEngine.js';


export default class UiController extends SketchEngine {
        
    constructor() {
        super();
        this.variables.baseurl = arguments[0].baseurl;
    }

    
    variables = {};


    execute = [
        'bgImage',
        'color',
        'textSize',
        'bgColor',
        'styles',
        'mobileNav',
        'responsive',
        'cardCategoreisLink',
        'navigation'
    ];


    components = [];


    selectors = {
        navDropdown: '.uk-navbar-dropdown',
        mobileNav: '#svp-mobile-nav ul'
    };


    html = {}


    catchDOM() {}


    bindEvents() {}


    functions = {
        
        
        navigation() {
            document.querySelectorAll('.uk-navbar a').forEach(aTag => {
                aTag.closest('li').classList.remove('uk-active');
            });
        },
        
        
        cardCategoreisLink() {
            document.querySelectorAll('.svp-card-categories .svp-links').forEach(span => {
                
                const spanPrev = span.previousElementSibling;
                spanPrev.innerText.split(',').forEach(category => {
                    let cat = category.trim();
                    var catLink = cat.split(' ').join('-');
                    
                    span.insertAdjacentHTML('afterbegin', `<div class="uk-inline-flex uk-flex-wrap">
                        <span uk-icon="icon: tag; ratio: .7" class="uk-margin-small-left"></span> <a href="${this.variables.baseurl}/categories/${catLink}">${cat}</a>
                    </div>`)
                })
                
                spanPrev.innerHTML = '';
            });
        },
        
        
        bgImage() {
            
            document.querySelectorAll('[data-bg]').forEach(bg => {
                
                const image = bg.getAttribute('data-bg');
                bg.style.background = `url(${image}) no-repeat center`;
                
                if (bg.getAttribute('bg-size')) {
                    const bgSize = bg.getAttribute('bg-size');
                    bg.style.backgroundSize = bgSize;
                }
                
                if (bg.getAttribute('bg-position')) {
                    const bgPos = bg.getAttribute('bg-position');
                    console.log(bgPos);
                    bg.style.backgroundPosition = bgPos;
                }
            });
        },
        
        
        color() {
            document.querySelectorAll('[data-color]').forEach(cl => {
                const color = cl.getAttribute('data-color');
                cl.style.color = color;
            });
        },
        
        
        bgColor() {
            document.querySelectorAll('[data-bg-color]').forEach(bgColor => {
                const color = bgColor.getAttribute('data-bg-color');
                bgColor.style.backgroundColor = color;
            })
            
        },
        
        
        textSize() {
            document.querySelectorAll('[data-font-size]').forEach(txt => {
                const size = txt.getAttribute('data-font-size');
                txt.style.fontSize = size;
            });
        },
        
        
        styles() {
            document.querySelectorAll('[data-style]').forEach(st => {
                const style = st.getAttribute('data-style');
                st.setAttribute('style', style);
            });
        },
        
        
        mobileNav() {
                        
            const mobileNav = document.querySelector(this.selectors.mobileNav);
            if (!mobileNav) return false;
            
            mobileNav.removeAttribute('class');
            mobileNav.classList.add('uk-nav-default', 'uk-nav-parent-icon', 'uk-nav');
            mobileNav.setAttribute('uk-nav', '');
            
            const lists = mobileNav.querySelectorAll('li');
            console.log(lists);
            
            lists.forEach(li => {
                if (li.querySelector('.uk-navbar-dropdown')) {
                    
                    li.classList.add('uk-parent')
                    
                    const dropdown = li.querySelector('.uk-navbar-dropdown');
                    const navHtml = dropdown.innerHTML;
                    
                    dropdown.remove();
                    
                    const dom = new DOMParser().parseFromString(navHtml, "text/html");
                    const navEl = dom.querySelector('ul');
                    
                    navEl.removeAttribute('class')
                    navEl.classList.add('uk-nav-sub');
                    li.firstElementChild.insertAdjacentElement('afterend', navEl);
                }
            });

        },
        
        
        responsive() {
            /*
             * add attributes like in the example
             * data-responsive="max-width[100]; style[color: ...; font-size: ...;]"
             */
            
            
            document.querySelectorAll('[data-responsive]').forEach(elem => {
                const str = elem.getAttribute('data-responsive');
                const match = str.match(/max-width[\s+]?\[(.*?)\]\;/g);
                const maxWidth = match[0].match(/\[(.*?)\]/)[1];
                const styles = str.match(/style[\s+]?\[(.*?)\]/)[1];

                let myFunction = x => {
                    if (x.matches) { // If media query matches
                        elem.setAttribute('style', styles);
                    } else {
                        elem.removeAttribute('style')
                    }
                }

                let x = window.matchMedia("(max-width: "+maxWidth+"px)");
                myFunction(x);
                x.addListener(myFunction);
            });
        }

    }

}