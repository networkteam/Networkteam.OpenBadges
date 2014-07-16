Networkteam.OpenBadges
======================

A Mozilla OpenBadges issuer implementation for TYPO3 Flow and Neos

What does it do?
----------------

This package provides the infrastructure to issue OpenBadges badges from a TYPO3 Neos system.
The badge classes can be managed with a backend module and several REST endpoints provide assertion metadata for *hosted*
assertions. A node type to reward a badge once one or multiple validations of an assertion are complete is supplied.

Installation
------------

Add the composer package to your composer.json::

  composer require networkteam/openbadges

Add the routes for the Networkteam.OpenBadges package to ``Configuration/Routes.yaml``::

  ##
  # Networkteam OpenBadges subroutes

  -
    name: 'Open Badges'
    uriPattern: 'openbadges/<NetworkteamOpenBadgesSubroutes>'
    subRoutes:
      'NetworkteamOpenBadgesSubroutes':
        package: 'Networkteam.OpenBadges'

The backend module, node types, TypoScript and JavaScript are automatically registered once the package is installed.

A ``Networkteam.OpenBadges:BadgeReward`` node should be placed on document nodes to reward a badge. The inspector allows
to choose a badge class that will be rewarded.

Implement the server-side code to assert one step of the badge assertion (e.g. in a quiz plugin)::

  $assertionStep = $this->badgeAsserter->assertStep($badgeClass, $node->getIdentifier());
  $result['badgeAssertionStep'] = array(
		'badgeClassIdentifier' => $this->persistenceManager->getIdentifierByObject($badgeClass),
		'stepIdentifier' => $assertionStep->getIdentifier(),
		'token' => $assertionStep->getToken()
	);

Send the result to the client-side (e.g. in an AJAX response) and call a method to register the validated assertion step::

  Networkteam.OpenBadges.assertionStepValidated(result.badgeClassIdentifier, result.stepIdentifier, result.token);

Once all steps are validated, a modal dialog will be shown that allows to claim the badge and send it to a Mozilla Backpack account.

Open issues
-----------

This package is work in progress and not yet stable for production.

License
-------

Copyright (c) 2014 Christopher Hlubek, networkteam GmbH

Permission is hereby granted, free of charge, to any person obtaining a copy of this
software and associated documentation files (the "Software"), to deal in the
Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
and to permit persons to whom the Software is furnished to do so, subject to the
following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
