var _ = require('lodash');

module.exports = {

	defaults: function(args) {
		return _.defaults(args);
	},

	notifyOptions: function(status, override) {
		var options = {
			taskName: 'Task',
			title: ( status === 'pass') ? 'Passed' : 'Failed',
			message: ( status === 'pass' ) ? '<%= taskName %> Completed Successfully' : '<%= taskName %> Failed',
			icon: './node_modules/gulp-phpunit/assets/test-' + status + '.png'
		};

		var newOptions     = _.merge(options, override);
		newOptions.message = _.template(newOptions.message)(newOptions);
		return newOptions;

	}

}
