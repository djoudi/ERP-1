// Generated by CoffeeScript 1.4.0
(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  define(['backbone', 'settings', 'models/email'], function(Backbone, Settings, Email) {
    var Emails;
    return Emails = (function(_super) {

      __extends(Emails, _super);

      function Emails() {
        return Emails.__super__.constructor.apply(this, arguments);
      }

      Emails.prototype.model = Email;

      Emails.prototype.initialize = function(items, options) {
        if (options.contato != null) {
          return this.contato = options.contato;
        }
      };

      Emails.prototype.url = function() {
        var base;
        base = this.contato != null ? "" + (this.contato.url()) : Settings.api.url;
        return base += "/telefones";
      };

      return Emails;

    })(Backbone.Collection);
  });

}).call(this);
