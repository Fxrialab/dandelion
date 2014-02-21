function DropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('span');
    this.opts = this.dd.find('ul.dropdown > li');
    this.val = '';
    this.index = -1;
    this.img = '';
    this.initEvents();
}
DropDown.prototype = {
    initEvents : function() {
        var obj = this;

        obj.dd.on('click', function(event){
            $(this).toggleClass('active');
            return false;
        });

        obj.opts.on('click',function(){
            var opt = $(this);
            console.log(opt.children().html().replace(opt.text(), ''));
            obj.val = opt.text();
            obj.index = opt.index();
            obj.img = opt.children().html().replace(opt.text(), '');
            obj.placeholder.html(obj.img);
        });
    },
    getValue : function() {
        return this.val;
    },
    getIndex : function() {
        return this.index;
    },
    getImage : function() {
        return this.img;
    }
}

$(function() {

    $(document).click(function() {
        // all dropdowns
        $('.wrapper-dropdown-2').removeClass('active');
    });

});