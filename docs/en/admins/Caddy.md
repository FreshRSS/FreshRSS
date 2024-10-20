## Using Caddy as a Reverse Proxy

## Using Caddy as a Reverse Proxy with a Subfolder

To set up FreshRSS behind a reverse proxy with Caddy and using a subfolder, follow these steps:

1. **Configure Caddyfile:**

    Update your Caddyfile with the following configuration:

    ```plaintext
    example.com {
        redir /freshrss /freshrss/i/
        route /freshrss* {
            uri strip_prefix /freshrss
            reverse_proxy freshrss:80 {
                header_up Host {host}
                header_up X-Real-IP {remote}
                header_up X-Forwarded-Proto {scheme}
                header_up X-Forwarded-Host {host}
                header_up X-Forwarded-For {remote}
                header_up X-Forwarded-Ssl {on}
                header_up X-Forwarded-Prefix "/freshrss/"
            }
        }
    }
    ```

    Replace `example.com` with your actual domain and `freshrss` with the subfolder where FreshRSS is hosted.

2. **Update FreshRSS Configuration:**

    Open the `config.php` file in your FreshRSS installation and update the `base_url` parameter to match the subfolder configuration:

    ```php
    'base_url' => 'https://example.com/freshrss',
    ```

    Replace `example.com` with your actual domain and `freshrss` with the subfolder name specified in the Caddyfile.

3. **Restart Caddy and FreshRSS:**

    Restart Caddy to apply the configuration changes:

    ```bash
    systemctl restart caddy
    ```

    Restart FreshRSS to ensure that it recognizes the new base URL:

    ```bash
    docker compose restart freshrss
    ```

4. **Access FreshRSS:**

    FreshRSS should now be accessible at `https://example.com/freshrss`.

### Example Caddyfile Entry

```plaintext
example.com {
    redir /freshrss /freshrss/i/
    route /freshrss* {
        uri strip_prefix /freshrss
        reverse_proxy freshrss:80 {
            header_up Host {host}
            header_up X-Real-IP {remote}
            header_up X-Forwarded-Proto {scheme}
            header_up X-Forwarded-Host {host}
            header_up X-Forwarded-For {remote}
            header_up X-Forwarded-Ssl {on}
            header_up X-Forwarded-Prefix "/freshrss/"
        }
    }
}
```

Replace `example.com` with your actual domain and `freshrss` with the subfolder name where FreshRSS is hosted.

### Note


Ensure that the Docker container name for FreshRSS (freshrss in this example) matches the name used in the Caddyfile configuration. By following these steps, you should be able to successfully configure Caddy as a reverse proxy with a subfolder for FreshRSS. Remember to update the base_url parameter in the FreshRSS configuration to match the subfolder configuration set in Caddy.
