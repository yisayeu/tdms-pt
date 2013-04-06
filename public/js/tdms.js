(function ($) {
    Tdms = {};
    Tdms.helper = {};
    
    
    /**
     * Grid heleper.
     */
    Tdms.helper.grid = function() {
        this.init.apply(this, arguments);
    };
        
    /**
     * Inits the helper.
     */
    Tdms.helper.grid.prototype = {
        grid: null,
        form: null,
        content: null,
        loading: null,
            
        init: function(grid) {
            this.grid = grid;
            this.form = this.grid.find('form');
            this.content = this.grid.find('div.content');
            this.loading = $('#loading');
            
            this.initFilters();
            this.initLinks();
        },
        
        /**
         * Binds `change` event for the grid filters.
         */
        initFilters: function() {
            this.grid.find('.filters select').change($.proxy(function() {
                this.load();    
            }, this));
        },
        
        /**
         * Changes all the links inside the grid to be sent via AJAX.
         */
        initLinks: function() {
            var me = this;        
            
            this.content.find('a').click(function() {
                me.load($(this).attr('href'));
                return false;
            });
        },
        
        /**
         * Loads the grid.
         */
        load: function(url) {
            if ('undefined' == typeof url) {
                url = this.form.attr('action');
            }
            
            this.loading.show();
            
            $.ajax({
                type: 'POST',
                context: this,
                data: this.form.serializeArray(),
                url: url,
                success: function(html) {
                    this.update(html);
                    
                    this.loading.hide();
                },
                error: function() {
                    // TODO: handle failure. 
                }
            });
        },
        
        /**
         * Updaes grid contents.
         */
        update: function(html) {
            this.content.html(html);
            this.initLinks();
        },
        
        /**
         * Resets the filters.
         */
        reset: function() {
            this.grid.find('.filters select').val('');
        }
    };
    
    
    /**
     * Product-create form helper.
     */
    Tdms.helper.createForm = function() {        
        this.init.apply(this, arguments);
    };
    
    Tdms.helper.createForm.prototype = {
        trigger: null,
        dialog: null,
        title: null,
        content: null,
        loading: null,
            
        /**
         * Inits the helper.
         */
        init: function(trigger, grid) {
            this.trigger = trigger;
            this.grid = grid;  
            this.dialog = $('#modal-dialog');
            this.title = this.dialog.find('.modal-header h3');
            this.content = this.dialog.find('.modal-body p');        
            this.loading = $('#loading');
            
            this.trigger.click($.proxy(function() {
                this.load();
                return false;
            }, this));
        },
        
        /**
         * Loads the form contents.
         */
        load: function() {
            this.title.html(this.trigger.html());
            
            this.loading.show();
            
            $.ajax({
                type: 'GET',
                context: this,
                url: this.trigger.attr('href'),
                success: function(html) {
                    this.update(html);                
                    
                    this.loading.hide();
                },
                error: function() {
                    // TODO: handle failure. 
                }
            });        
        },
        
        /**
         * Updates modal dialog content.
         */
        update: function(html) {
            // Check if the html contains create-product form.
            if ($(html).find('form[id=ProductsCreate]').length) {                
                this.content.html(html);                
                this.dialog.modal();            
                this.initForm();
            } else {
                
                this.dialog.modal('hide');
                
                // If the html does not contain the form, it's supposed to contain updated grid contents. 
                this.grid.update(html);
                // Reset the filtration form.
                this.grid.reset();
            }
        },
        
        /**
         * Overrides handler of the form submit button to submit the form via AJAX.   
         */
        initForm: function() {                       
            this.content.find('input[type=submit]').click($.proxy(function() {
                var form  = this.content.find('form');
                            
                this.loading.show();
                
                $.ajax({
                    type: 'POST',
                    context: this,
                    data: form.serializeArray(),
                    url: this.trigger.attr('href'),
                    success: function(html) {
                        this.update(html);                    
                        
                        this.loading.hide();
                    },
                    error: function() {
                        // TODO: handle failure. 
                    }
                });    
                                
                return false;
            }, this));            
        },
    };
        

    var grid = new Tdms.helper.grid($('#products-grid'));
    var createForm = new Tdms.helper.createForm($('#products-create'), grid);
    
})(window.jQuery);