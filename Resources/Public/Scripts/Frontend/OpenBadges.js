var Networkteam = window.Networkteam||{};
Networkteam.OpenBadges = Networkteam.OpenBadges||{};

(function($) {

	Networkteam.OpenBadges.assertionStepValidated = function(badgeClassIdentifier, stepIdentifier, token) {
		window.localStorage.setItem(badgeClassIdentifier + ':' + stepIdentifier, token);
		$.event.trigger({
			type: 'OpenBadges:AssertionStepValidated',
			badgeClassIdentifier: badgeClassIdentifier,
			stepIdentifier: stepIdentifier,
			token: token
		});
		console.debug('Assertion step validated', badgeClassIdentifier, stepIdentifier, token);
	};

	$.fn.badgeRewardWidget = function(options) {

		var $this = $(this),
			$steps = $this.find('.openbadges-badge-assertion-steps'),
			badgeClassIdentifier = $this.find('.openbadge-badge').data('identifier'),
			nodeIdentifier = $this.data('identifier'),
			assertionSteps = {},
			assertionStepsCount;
		$steps.hide();

		$steps.find('li').each(function() {
			assertionSteps[$(this).data('identifier')] = {
				validated: false,
				token: null
			};
		});
		assertionStepsCount = $steps.find('li').length;

		function completedAssertionSteps() {
			var count = 0,
				identifier;
			for (identifier in assertionSteps) {
				if (assertionSteps.hasOwnProperty(identifier) && assertionSteps[identifier].validated) {
					count++;
				}
			}
			return count;
		}

		$this.find('.openbadges-status-count').text(assertionStepsCount);

		function enableClaimButtonIfCompleted() {
			if (completedAssertionSteps() === assertionStepsCount) {
				$this.find('.openbadges-claim-button').removeClass('disabled');
			}
		}

		enableClaimButtonIfCompleted();

		function showModalIfCompleted() {
			if (completedAssertionSteps() === assertionStepsCount) {
				$('#modal-' + nodeIdentifier).modal();
			}
		}

		$(document).on('OpenBadges:AssertionStepValidated', function(event) {
			console.debug('Received OpenBadges:AssertionStepValidated event', event)
			if (event.badgeClassIdentifier === badgeClassIdentifier) {
				if (assertionSteps[event.stepIdentifier]) {
					assertionSteps[event.stepIdentifier].validated = true;
					assertionSteps[event.stepIdentifier].token = event.token;
				}

				$this.find('.openbadges-status-current').text(completedAssertionSteps());

				showModalIfCompleted();
				enableClaimButtonIfCompleted();
			}
		});

		$('.openbadges-reward-modal form').submit(function(e) {
			var $form = $(this),
				$xhr;
			e.preventDefault();

			$.post($form.attr('action'), {
				badgeClass: badgeClassIdentifier,
				recipientEmail: $form.find('input[type="email"]').val(),
				tokens: $.map(assertionSteps, function(value) { return value.token; })
			}).done(function(result) {
				$form.fadeOut();
				$('.openbadges-messages').empty().append($('<div class="alert alert-info" role="alert">Now sending your badge to Mozilla Backpack...</div>'));

				if (result.location) {
					OpenBadges.issue([result.location], function(errors, successes) {
						// errors => [{assertion: 'http://...', reason: 'INACCESSIBLE'}]
						console.debug(errors, successes);

						// TODO Show error / success mesage and close button
					});
				} else {
					// TODO Handle missing assertion URI
				}
			}).fail(function() {
				$('.openbadges-messages').empty().append($('<div class="alert alert-danger" role="alert"><strong>Error!</strong> There was an error claiming you badge.</div>'));
			}).always(function() {
				// TODO Remove spinner / loader from button
			});

			// TODO Add spinner / loader to button

			return false;
		});

	};

	$('.openbadges-badge-reward').badgeRewardWidget();

})(jQuery);