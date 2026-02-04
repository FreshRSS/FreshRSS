## Using Caddy as a Reverse Proxy

How to configure Caddy as a reverse proxy to serve FreshRSS through a subfolder or subdomain

## Using Caddy as a Reverse Proxy with a Subfolder

To set up FreshRSS behind a reverse proxy with Caddy and using a subfolder, follow these steps:

1. **Configure Caddyfile:**

    Update your Caddyfile with the following configuration:

    ``` caddy
	example.com {
		redir /subfolder /subfolder/ # Just to redirect users that are missing the closing slash to the correct page
		handle_path /subfolder/* { # Actually configures the used subfolder (also internally strips the path prefix)
			reverse_proxy freshrss:80 { # Enables the reverse proxy for the configured program:port
				header_up X-Forwarded-Prefix "/subfolder" # Sets the correct header for the login cookies
			}
		}
	}
    ```

    Replace `example.com` with your actual domain and the four instances of `subfolder` with the subfolder where you want FreshRSS to be hosted.

    > **_NOTE:_** Ensure that the Docker container name for FreshRSS (freshrss in this example) matches the name used in the Caddyfile configuration.

2. **Update FreshRSS Configuration:**

    Open the `config.php` file in your FreshRSS installation and update the `base_url` parameter to match the subfolder configuration:

    ```php
    'base_url' => 'https://example.com/subfolder',
    ```

    Replace `example.com` with your actual domain and `subfolder` with the same subfolder name specified in the Caddyfile.

3. **Restart Caddy and FreshRSS:**

    Restart Caddy to apply the configuration changes:

    ```sh
    docker compose restart caddy
    ```

    Restart FreshRSS to ensure that it recognizes the new base URL:

    ```sh
    docker compose restart freshrss
    ```

4. **Access FreshRSS:**

    FreshRSS should now be accessible at `https://example.com/subfolder`.

## Using Caddy as a Reverse Proxy with a Subdomain

To set up FreshRSS behind a reverse proxy with Caddy and using a subdomain, follow these steps:

1. **Configure Caddyfile:**

    Update your Caddyfile with the following configuration:

    ``` caddy
	subdomain.example.com { # The url Caddy should serve the proxy on
		reverse_proxy freshrss:80 # Enables the reverse proxy for the configured program:port
	}
    ```

    Replace `example.com` with your actual domain and `subdomain` with the subfolder where you want FreshRSS to be hosted.

    > **_NOTE:_** Ensure that the Docker container name for FreshRSS (freshrss in this example) matches the name used in the Caddyfile configuration.
    > **_NOTE:_** Make sure to set the DNS Records for your configured subdomain.

2. **Update FreshRSS Configuration:**

    Open the `config.php` file in your FreshRSS installation and update the `base_url` parameter to match the subdomain configuration:

    ```php
    'base_url' => 'https://subdomain.example.com/',
    ```

    Replace `example.com` with your actual domain and `subdomain` with the same subdomain specified in the Caddyfile.

3. **Restart Caddy and FreshRSS:**

    Restart Caddy to apply the configuration changes:

    ```sh
    docker compose restart caddy
    ```

    Restart FreshRSS to ensure that it recognizes the new base URL:

    ```sh
    docker compose restart freshrss
    ```

4. **Access FreshRSS:**

    FreshRSS should now be accessible at `https://subdomain.example.com/`.
