<?php
/**
 * Class to allow plugin updates to be ditributed
 * via Git/GitHub releases
 *
 * @package Logic\Loki
 * @author Logic Design and Consultancy Ltd
 **/
class LogicPluginUpdater
{
    /**
     * Slug of plugin to be updated
     *
     * @var string
     **/
    private $slug;

    /**
     * Parsed metadata from plugin
     *
     * @var array
     **/
    private $pluginData;

    /**
     * GitHub username
     *
     * @var string
     **/
    private $username;

    /**
     * Slug of GitHub repo
     *
     * @var string
     **/
    private $repo;

    /**
     * Full file path of plugin
     *
     * @var string
     **/
    private $pluginFile;

    /**
     * Result from GitHub API call
     *
     * @var object
     **/
    private $githubAPIResult;

    /**
     * Access token for use with private GitHub repos
     *
     * @var string
     **/
    private $accessToken;

    /**
     * Constructor call to instantiate required vars
     *
     * @param string $pluginFile - Result of __FILE__ from plugin file
     * @param string $gitHubUsername - Username of GitHub account
     * @param string $gitHubProjectName - Name of project in GitHub
     * @param string $accessToken - Access Token for private repo
     * 
     * @return void
     * @author Logic Design & Consultancy Ltd
     **/
    public function __construct($pluginFile, $gitHubUsername, $gitHubProjectName, $accessToken = '') {
        add_filter("pre_set_site_transient_update_plugins", array($this, "setTransient"));
        add_filter("plugins_api", array($this, "setPluginInfo"), 10, 3);
        add_filter("upgrader_post_install", array($this, "postInstall"), 10, 3);
 
        $this->pluginFile = $pluginFile;
        $this->username = $gitHubUsername;
        $this->repo = $gitHubProjectName;
        $this->accessToken = $accessToken;
    }

    /**
     * Set additional data which is only accessible after plugins_api hook
     * 
     * @return void
     * @author Logic Design & Consultancy Ltd
     **/
    private function initPluginData() {
        $this->slug = plugin_basename($this->pluginFile);
        $this->pluginData = get_plugin_data($this->pluginFile);
    }

    /**
     * Fetch releases from GitHub
     * 
     * @return void
     * @author Logic Design & Consultancy Ltd
     **/
    private function getRepoReleaseInfo() {
        // Check if we already have fetched releases
        if (!empty($this->githubAPIResult)) {
            return;
        }

        // Set the url to use the GitHub API
        $url = "https://api.github.com/repos/{$this->username}/{$this->repo}/releases";
         
        // If we have an access token, let's add it to the request url
        if (!empty($this->accessToken)) {
            $url = add_query_arg(array("access_token" => $this->accessToken), $url);
        }
         
        // Fetch the result of the API call
        $this->githubAPIResult = wp_remote_retrieve_body(wp_remote_get($url));
        if (!empty($this->githubAPIResult)) {
            $this->githubAPIResult = @json_decode($this->githubAPIResult);
        }

        // Use only the latest release
        if (is_array($this->githubAPIResult)) {
            $this->githubAPIResult = $this->githubAPIResult[0];
        }
    }

    /**
     * Set the transient data for update checking
     * 
     * Push in plugin version information to get the update notification
     * 
     * @return object
     * @author Logic Design & Consultancy Ltd
     **/
    public function setTransient($transient) {
        // If we have checked the plugin data before, don't re-check
        if (empty($transient->checked)) {
            return $transient;
        }

        // Get plugin & GitHub release information
        $this->initPluginData();
        $this->getRepoReleaseInfo();

        // Check the versions if we need to do an update
        $doUpdate = version_compare($this->githubAPIResult->tag_name, $transient->checked[$this->slug]);

        // Update the transient to include our updated plugin data
        if ($doUpdate == 1) {
            $package = $this->githubAPIResult->zipball_url;
         
            // Include the access token for private GitHub repos
            if (!empty($this->accessToken)) {
                $package = add_query_arg(array("access_token" => $this->accessToken), $package);
            }
         
            $obj = new stdClass();
            $obj->slug = $this->slug;
            $obj->new_version = $this->githubAPIResult->tag_name;
            $obj->url = $this->pluginData["PluginURI"];
            $obj->package = $package;
            $transient->response[$this->slug] = $obj;
        }
         
        return $transient;
    }

    /**
     * Set the new update information from GitHub for the update lightbox
     * 
     * @return object
     * @author Logic Design & Consultancy Ltd
     **/
    public function setPluginInfo($false, $action, $response) {
        // Get plugin & GitHub release information
        $this->initPluginData();
        $this->getRepoReleaseInfo();

        // If nothing is found, do nothing
        if (empty($response->slug) || $response->slug != $this->slug) {
            return false;
        }

        // Add our plugin information
        $response->last_updated = $this->githubAPIResult->published_at;
        $response->slug = $this->slug;
        $response->plugin_name  = $this->pluginData["Name"];
        $response->version = $this->githubAPIResult->tag_name;
        $response->author = $this->pluginData["AuthorName"];
        $response->homepage = $this->pluginData["PluginURI"];
         
        // This is our release download zip file
        $downloadLink = $this->githubAPIResult->zipball_url;
         
        // Include the access token for private GitHub repos
        if (!empty($this->accessToken)) {
            $downloadLink = add_query_arg(
                array("access_token" => $this->accessToken),
                $downloadLink
            );
        }
        $response->download_link = $downloadLink;

        // We're going to parse the GitHub markdown release notes, include the parser
        require_once(plugin_dir_path(__FILE__) . "Parsedown.php");

        // Create tabs in the lightbox
        $response->sections = array(
            'description' => $this->pluginData["Description"],
            'changelog' => class_exists("Parsedown")
                ? Parsedown::instance()->parse($this->githubAPIResult->body)
                : $this->githubAPIResult->body
        );

        // Gets the required version of WP if available
        $matches = null;
        preg_match("/requires:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches);
        if (!empty($matches)) {
            if (is_array($matches)) {
                if (count($matches) > 1) {
                    $response->requires = $matches[1];
                }
            }
        }
         
        // Gets the tested version of WP if available
        $matches = null;
        preg_match("/tested:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches);
        if (!empty($matches)) {
            if (is_array($matches)) {
                if (count($matches) > 1) {
                    $response->tested = $matches[1];
                }
            }
        }

        return $response;
    }

    /**
     * Perform post update tasks
     * 
     * @return array
     * @author Logic Design & Consultancy Ltd
     **/
    public function postInstall($true, $hook_extra, $result) {
        // Get plugin information
        $this->initPluginData();

        // Remember if our plugin was previously activated
        $wasActivated = is_plugin_active($this->slug);

        // Since we are hosted in GitHub, our plugin folder would have a dirname of
        // reponame-tagname change it to our original one:
        global $wp_filesystem;
        $pluginFolder = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname($this->slug);
        $wp_filesystem->move($result['destination'], $pluginFolder);
        $result['destination'] = $pluginFolder;

        // Re-activate plugin if needed
        if ($wasActivated) {
            $activate = activate_plugin($this->slug);
        }

        return $result;
    }
}