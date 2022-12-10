export default class SketchEngine {

    domElements = [];

    request = (path, callback, obj = {}) => {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                callback(this.responseText)
            }
        };
        xhttp.open("POST", path, !this.synchronousComponents);
        xhttp.send(JSON.stringify(obj));
    }

    constructor() {

        const insertComponents = (callback) => {

            if (this.components.length) {

                this.components.forEach(componentObject => {
                    const component = Object.keys(componentObject)
                    const elems = document.querySelectorAll(`[data-component="${component}"]`)
                    const file = componentObject[component];

                    this.request(file, res => {
                        elems.forEach(elem => {
                            elem.removeAttribute('data-component');
                            elem.classList.add('sketch-component');
                            elem.innerHTML = res
                            const x = elem.querySelector(`[data-component]`);

                            if (x) {
                                const componentName = x.getAttribute('data-component');
                                const index = this.components.findIndex(item => item[componentName])
                                const missedFilePath = this.components[index][componentName];
                             
                                this.request(missedFilePath, res => {
                                    x.removeAttribute('data-component');
                                    x.classList.add('sketch-component');
                                    x.innerHTML = res
                                    elem.outerHTML = elem.outerHTML
                                });
                            }
                        })
                    })
                })
            }

            callback()
        }
        
        const execute = () => {
            this.execute.forEach(method => {
                this.functions[method].call(this)
            })
        }

        window.addEventListener('DOMContentLoaded', () => {
            insertComponents(() => {
                this.catchDOM();
                this.bindEvents();
                execute(); 
            })
        })
    }

    /**
     * @Set this.dom.set('input', document.querySelector('input'));
     * @Get this.dom.get('input');
     */
    dom = {
        set: (elName, el) => {
            this.domElements[elName]  = el;
        },

        get: (elName) => {
            return this.domElements[elName];
        }
    }


    /**
     * @pubsub First you must publish some event and then it is posible to subscribe to it. 
     */
    pubsub = {
        events: {},
        subscribe: function (evName, fn) {
            this.events[evName] = this.events[evName] || [];
            this.events[evName].push(fn);
        },
        unsubscribe: function (evName, fn) {
            if (this.events[evName]) {
                this.events[evName] = this.events[evName].filter(f => f !== fn);
            }
        },
        publish: function (evName, data = undefined) {
            if (this.events[evName]) {
                this.events[evName].forEach(f => {
                    f(data);
                });
            }
        }
    }


    lib = function(el = undefined) {

        const isNodeList = (nodes) => {
            var stringRepr = Object.prototype.toString.call(nodes);
        
            return typeof nodes === 'object' &&
                /^\[object (HTMLCollection|NodeList|Object)\]$/.test(stringRepr) &&
                (typeof nodes.length === 'number') &&
                (nodes.length === 0 || (typeof nodes[0] === "object" && nodes[0].nodeType > 0));
        }

        return  {
            el: () => {
                // Check if is node
                if (!el) {
                    return undefined;
                } else if (el.nodeName) {
                    return [el];
                } else if (isNodeList(el)) {
                    return Array.from(el)
                } else if (typeof(el) === 'string' || typeof(el) === 'STRING') {
                    return Array.from(document.querySelectorAll(el));
                } else {
                    return undefined;
                }
            },
    
            on(event, callback, classList = undefined) {
                if (!classList) {
                    this.el().forEach(item => {
                        item.addEventListener(event, callback.bind(item))
                    })
                } else {
                    this.el().forEach(item => {
                        item.addEventListener(event, (e) => {
                            if (e.target.closest(classList)) {
                                callback.call(e.target.closest(classList), e)
                            }
                        })
                    })
                }
            },
    
            css(params) {
                for (const key in params) {
                    if (Object.hasOwnProperty.call(params, key)) {
                        const cssVal = params[key];
                        this.el().forEach(el => el.style[key] = cssVal)
                    }
                }
            },

            attr(param1, param2 = undefined) {

                if (!param2) {
                    return this.el()[0].getAttribute(param1)
                }
                this.el().forEach(el => el.setAttribute(param1, param2))
            },
    
            removeAttr(param) {
                this.el().forEach(el => el.removeAttribute(param))
            },
            
            addClass(param) {
                this.el().forEach(el => el.classList.add(param))
            },

            removeClass(param) {
                this.el().forEach(el => el.classList.remove(param))
            },
            
            slug(str) {
                return str
                    .toLowerCase()
                    .replace(/[^\u00BF-\u1FFF\u2C00-\uD7FF\w]+|[\_]+/ig, '-')
                    .replace(/ +/g,'-')
                    ;
            },

            remove(param) {
                this.el().forEach(el => el.remove())
            },

            val(param = undefined) {
                let val;

                if (param === undefined) {
                    this.el().forEach(el => {
                        val = el.value;
                    })
                } else {
                    this.el().forEach(el => {
                        el.value = param;
                    })
                }

                return val;
            },

            text(msg = undefined) {
                if (msg === undefined) {
                    return el.innerText;
                } else {
                    this.el().forEach(el => {
                        el.innerText = msg;
                    })
                }
            },

            html(data = undefined) {
                if (data === undefined) {
                    return el.innerHTML;
                } else {
                    this.el().forEach(el => {
                        el.innerHTML = data;
                    })
                }
            },
            
            formData(form, asFormData = false) {
                
                let object = {};
                const formData = form.querySelectorAll('[name]');
                
                formData.forEach((item) => {
                    
                    if (item.outerHTML.match(/[\<]select/)) {
                        
                        if (item.getAttribute('multiple')) {
                            
                            function getSelectValues(select) {
                                
                                let result = [];
                                let options = select && select.options;
                                let opt;

                                for (var i=0, iLen=options.length; i<iLen; i++) {
                                    opt = options[i];

                                    if (opt.selected && opt.getAttribute('value')) {
                                        result.push(opt.value || opt.text);
                                    }
                                }
                                return result;
                            }
                            
                            const selectArr = getSelectValues(item);
                            const res       = selectArr.length ? selectArr : undefined;
                            
                            if (!!res) {
                                let key = item.getAttribute('name');
                                key = key.replace(/(\[\])/, '');
                                object[key] = getSelectValues(item);
                            }
                        } else {
                        
                            const index = item.selectedIndex;
                            const val = item.querySelectorAll('option')[index].getAttribute('value');

                            if (val && val.length) {
                                object[item.getAttribute('name')] = val;
                            }    
                        }
                        
                    } else {
                        
                        if (item.getAttribute('type') && item.getAttribute('type') === 'checkbox') {
                            
                            if (item.checked) {
                                object[item.getAttribute('name')] = 'on';
                            }
                        } else if (item.getAttribute('type') && item.getAttribute('type') === 'radio') {
                            
                            if (item.checked) {
                                object[item.getAttribute('name')] = 'on';
                            }
                        } else if (item.outerHTML.match(/[\<]textarea/)) {
                            
                            if (item.value.trim().length) {
                                object[item.getAttribute('name')] = item.value;
                            }
                        } else {
                        
                            if (item.value.trim().length) {
                                object[item.getAttribute('name')] = item.value;
                            }
                        }
                    }
                });
                
                
                if (asFormData) {
                    
                    const FD = new FormData();

                    for (const key in object) {
                        if (Object.hasOwnProperty.call(object, key)) {
                            const val = object[key];

                            FD.append(key, val);
                        }
                    }

                    return FD;
                }
                
                return object;
            }
        }
    }
    

    loadComponent(pathToComponent, callback, obj = undefined) {
        return this.request(pathToComponent, html => {
            callback(html);
        }, obj);
    }


    /////////////////////////////// EXTENDING SKETCH ENGINE ///////////////////////////////
    updateComponent(componentName) {
        
        const metaBase = document.querySelector('meta[name="baseurl"]');
        const baseurl = metaBase ? metaBase.getAttribute('content') : location.origin;
        
        const componentEl = document.querySelector(`[data-component="${componentName}"]`);
        if (!componentEl) return false;
        const argumentAttr = componentEl.getAttribute('data-component-argument');
        const arg = argumentAttr ? `?arg=${argumentAttr}` : '';
        
        fetch(`${baseurl}/admin/components/${componentName + arg}`, {
            method: "get",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(res => res.text())
        .then(res => {
            document.querySelectorAll(`[data-component="${componentName}"]`).forEach(comp => comp.innerHTML = res);
        })
    }







    /*
    * Blueprint for extendable class
    */

    // synchronousComponents = true;
    
    
    // variables = {};


    // execute = [];


    // components = [];


    // selectors = {};


    // html = {}


    // catchDOM() {}


    // bindEvents() {}


    // functions = {}
    
    
}