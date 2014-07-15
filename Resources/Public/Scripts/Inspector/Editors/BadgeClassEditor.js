define(
[
	'Library/jquery-with-dependencies',
	'Content/Inspector/Editors/SelectBoxEditor'
],
function(
	$,
	SelectBoxEditor
) {
	return SelectBoxEditor.extend({
		init: function() {
			this.set('placeholder', 'Loading ...');
			this._loadOptions();
			this._super();
		},

		_loadOptions: function() {
			var that = this;

			this._loadValuesFromController(
				'/openbadges/badges',
				function(results) {
					var values = {};

					values[''] = {
						value: 'null',
						label: 'No badge',
						disabled: false
					};

					$.each(results, function() {
						values['"' + this.identifier + '"'] = {
							value: '"' + this.identifier + '"',
							label: this.name,
							disabled: false
						};
					});
					that.setProperties({
						values: values,
						placeholder: 'Select badge'
					});
				}
			);
		}
	});
});
