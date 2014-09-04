function DropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('span');
    this.opts = this.dd.find('ul.dropdown > li');
    this.val = '';
    this.index = -1;
    this.img = '';
    this.inputHidden = this.dd.children('input');
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
            obj.val = opt.text();
            obj.index = opt.index();
            obj.img = opt.children().html().replace(opt.text(), '');
            obj.placeholder.html(obj.img);
            obj.inputHidden.attr('value', obj.placeholder.children('i').attr('class').replace(' icon-large', '').replace('icon-', ''));
        });

        console.log('new ',obj.inputHidden.attr('name'));
        obj.inputHidden.attr('value', obj.placeholder.html());
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