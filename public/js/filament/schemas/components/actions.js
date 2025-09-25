<<<<<<< HEAD
var o = () => ({
  isSticky: !1,
  init() {
    this.evaluatePageScrollPosition();
  },
  evaluatePageScrollPosition() {
    let i = this.$el.getBoundingClientRect(),
      t = i.top > window.innerHeight,
      e = i.top < window.innerHeight && i.bottom > window.innerHeight;
    this.isSticky = t || e;
  },
});
export { o as default };
=======
var i=()=>({isSticky:!1,enableSticky(){this.isSticky=this.$el.getBoundingClientRect().top>0},disableSticky(){this.isSticky=!1}});export{i as default};
>>>>>>> 443b60369b64d127b8d7d91c1163796596918291
