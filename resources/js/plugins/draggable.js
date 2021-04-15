import VDraggable from "vue-sortable-list";

export default {
    install: (app) => {
        const vue3Adapter = {
            directive(name, options) {
                app.directive(name, {
                    mounted(listElement, binding, vnode) {
                        options.inserted(listElement, binding, {
                            ...vnode,
                            elm: vnode.el,
                        });
                    },
                });
            },
        };
        VDraggable.install(vue3Adapter);
    },
};
