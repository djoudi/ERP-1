/**
 * Include this file _after_ the main backbone-forms file to override the default templates.
 * You only need to include templates you want to override.
 * 
 * Requirements when customising templates:
 * - Each template must have one 'parent' element tag.
 * - "data-type" attributes are required.
 * - The main placeholder tags such as the following are required: fieldsets, fields
 */
;(function() {
  var Form = Backbone.Form;

    
  //TWITTER BOOTSTRAP TEMPLATES
  //Requires Bootstrap 2.x
  Form.setTemplates({

    //HTML
    form: '\
      <form class="form-horizontal">{{fieldsets}}</form>\
    ',

    fieldset: '\
      <fieldset>\
        <legend>{{legend}}</legend>\
        {{fields}}\
      </fieldset>\
    ',

    field: '\
      <div class="control-group field-{{key}}">\
        <label class="control-label" for="{{id}}">{{title}}</label>\
        <div class="controls">\
          {{editor}}\
          <div class="help-inline">{{error}}</div>\
          <div class="help-block">{{help}}</div>\
        </div>\
      </div>\
    ',

    nestedField: '\
      <div class="field-{{key}}">\
        <div title="{{title}}" class="input-xlarge">{{editor}}\
          <div class="help-inline">{{error}}</div>\
        </div>\
        <div class="help-block">{{help}}</div>\
      </div>\
    ',

    list: '\
      <div class="bbf-list">\
        <ul class="unstyled clearfix">{{items}}</ul>\
        <div class="bbf-list-controls">\
          <button type="button" class="btn bbf-del" data-action="clear"> <i class="icon-trash"></i> '+__("BACKBONE_FORMS_LIST_CLEAR_BUTTON","Remover Todos")+' </button>\
          <button class="btn btn-primary bbf-add" data-action="add"><i class="icon-plus-sign"></i> '+__("BACKBONE_FORMS_LIST_ADD_BUTTON","Adicionar")+'</button>\
        </div>\
      </div>\
    ',

    listItem: '\
      <li class="clearfix">\
        <button type="button" class="btn bbf-del" data-action="remove"> <i class="icon-trash"></i></button>\
        {{editor}}\
      </li>\
    ',

    date: '\
      <div class="bbf-date">\
        <select data-type="date" class="bbf-date">{{dates}}</select>\
        <select data-type="month" class="bbf-month">{{months}}</select>\
        <select data-type="year" class="bbf-year">{{years}}</select>\
      </div>\
    ',

    dateTime: '\
      <div class="bbf-datetime">\
        <p>{{date}}</p>\
        <p>\
          <select data-type="hour" style="width: 4em">{{hours}}</select>\
          :\
          <select data-type="min" style="width: 4em">{{mins}}</select>\
        </p>\
      </div>\
    ',

    'list.Modal': '\
      <div class="bbf-list-modal">\
        {{summary}}\
      </div>\
    ',

    'listField': '\
      <div>\
        {{editor}}\
        <div class="help-inline">{{error}}</div>\
        <div class="help-block">{{help}}</div>\
      </div>\
      '
  }, {
  
    //CLASSNAMES
    error: 'error' //Set on the field tag when validation fails
  });


})();
