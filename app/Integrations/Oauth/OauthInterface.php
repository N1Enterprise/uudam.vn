<?php

namespace App\Integrations\Oauth;

interface OauthInterface
{
    /**
     * Redirect the user to the authentication page for the provider.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
	public function info($with = []);

	/**
     * Get the User instance for the authenticated user.
     */
	public function user(array $payload);


    /**
     * Get the name (identity) of provider.
     *
     * @return string
     */
    public function providerName(): string;


    /**
     * Get the type of oauth (OauthType enum).
     *
     * @return string
     */
    public function oauthType(): string;
}
