<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Subscription Conversion Template</title>
    <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <style>
        body {
            background-color: #87ceeb;
            margin: 0;
            padding: 0;
        }
        .outer-container {
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            color: #333;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }
        .textarea-container {
            height: 200px;
            overflow-y: auto;
        }
        .clear-button {
            background-color: #ff4c4c;
            color: white;
        }
        .clear-button:hover {
            background-color: #ff1a1a;
        }
        .result-container, .log-container, .saved-data-container {
            margin-top: 20px;
        }
        .result-container textarea {
            height: 100%;
            resize: vertical;
        }
        .saved-data-container pre {
            word-wrap: break-word;
            white-space: pre-wrap;
        }
        .log-container {
            max-height: 200px;
            overflow-y: auto;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
  <div class="outer-container">
        <div class="container">
            <h1 class="text-center text-primary">Sing-box Subscription Conversion Template</h1>
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">Help Information</h4>
                <p>Please select a template to generate the configuration file: choose the corresponding template based on the subscription node information, otherwise, it will not start.</p>
                <ul>
                    <li><strong>Default Template 1</strong>：Hong Kong, Taiwan, Singapore, Japan, United States, South Korea.</li>
                    <li><strong>Default Template 2</strong>：Singapore, Japan, United States, South Korea.</li>
                    <li><strong>Default Template 3</strong>：Hong Kong, Singapore, Japan, United States</li>
                    <li><strong>Default Template 4</strong>：Hong Kong, Japan, United States.</li>
                    <li><strong>Default Template 5</strong>：No region, universal.</li>
                </ul>
            </div>
            <form method="post" action="">
                <div class="form-group">
                    <label for="subscribeUrl">Subscription Link Address:</label>
                    <input type="text" class="form-control" id="subscribeUrl" name="subscribeUrl" required>
                </div>
                <fieldset class="form-group">
                    <legend>Select a template</legend>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="useDefaultTemplate" name="templateOption" value="default" checked>
                        <label class="form-check-label" for="useDefaultTemplate">Use default template</label>
                    </div>
                    <div class="form-row">
                        <div class="col-sm">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="useDefaultTemplate1" name="defaultTemplate" value="mixed" checked>
                                <label class="form-check-label" for="useDefaultTemplate1">Default template 1</label>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="useDefaultTemplate2" name="defaultTemplate" value="second">
                                <label class="form-check-label" for="useDefaultTemplate2">Default template 2</label>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="useDefaultTemplate3" name="defaultTemplate" value="fakeip">
                                <label class="form-check-label" for="useDefaultTemplate3">Default template 3</label>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="useDefaultTemplate4" name="defaultTemplate" value="tun">
                                <label class="form-check-label" for="useDefaultTemplate4">Default template 4</label>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="useDefaultTemplate5" name="defaultTemplate" value="ip">
                                <label class="form-check-label" for="useDefaultTemplate5">Default template 5</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="useCustomTemplate" name="templateOption" value="custom">
                        <label class="form-check-label" for="useCustomTemplate">Use Custom Template URL:</label>
                        <input type="text" class="form-control" id="customTemplateUrl" name="customTemplateUrl" placeholder="Enter Custom Template URL">
                    </div>
                </fieldset>
                <div class="form-group text-center">
                    <input type="submit" name="generateConfig" class="btn btn-primary" value="Generate Configuration File">
                </div>
            </form>

            <?php

$dataFilePath = '/tmp/subscription_data.txt';
$configFilePath = '/etc/neko/config/config.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generateConfig'])) {
    $subscribeUrl = trim($_POST['subscribeUrl']);
    $customTemplateUrl = trim($_POST['customTemplateUrl']);

    $dataContent = "Subscription Link Address: " . $subscribeUrl . "\n" . "Custom Template URL: " . $customTemplateUrl . "\n";
    file_put_contents($dataFilePath, $dataContent, FILE_APPEND);

    $subscribeUrlEncoded = urlencode($subscribeUrl);

    if ($_POST['templateOption'] === 'custom' && !empty($customTemplateUrl)) {
        $templateUrlEncoded = urlencode($customTemplateUrl);
    } elseif ($_POST['templateOption'] === 'default') {
            case 'mixed':
                $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_1.json");
                break;
            case 'second':
                $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_2.json");
                break;
            case 'fakeip':
                $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_3.json");
                break;
            case 'tun':
                $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_4.json");
                break;
            case 'ip':
                $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_5.json");
                break;
            default:
                $templateUrlEncoded = urlencode("https://raw.githubusercontent.com/Thaolga/Rules/main/Clash/json/config_1.json");
                break;
        }
    }

    $completeSubscribeUrl = "https://sing-box-subscribe-doraemon.vercel.app/config/{$subscribeUrlEncoded}&file={$templateUrlEncoded}";
    $tempFilePath = '/tmp/config.json';

    $command = "wget -O " . escapeshellarg($tempFilePath) . " " . escapeshellarg($completeSubscribeUrl);
    exec($command, $output, $returnVar);

    $logMessages = [];

    if ($returnVar !== 0) {
        $logMessages[] = "Unable to download content: " . htmlspecialchars($completeSubscribeUrl);
    } else {
        $downloadedContent = file_get_contents($tempFilePath);
        if ($downloadedContent === false) {
            $logMessages[] = "Unable to read the downloaded file content";
        } else {
            if (file_put_contents($configFilePath, $downloadedContent) === false) {
                $logMessages[] = "Unable to save the modified content to: " . $configFilePath;
            } else {
                $logMessages[] = "Configuration file generated and saved successfully: " . $configFilePath;
                $logMessages[] = "Generated and downloaded subscription URL: <a href='" . htmlspecialchars($completeSubscribeUrl) . "' target='_blank'>" . htmlspecialchars($completeSubscribeUrl) . "</a>";
            }
        }
    }

    echo "<div class='result-container'>";
    echo "<form method='post' action=''>";
    echo "<div class='form-group textarea-container'>";
    echo "<textarea id='configContent' name='configContent' class='form-control'>" . htmlspecialchars($downloadedContent) . "</textarea>";
    echo "</div>";
    echo "<div class='form-group text-center'>";
    echo "<button class='btn btn-info' type='button' onclick='copyToClipboard()'><i class='fas fa-copy'></i> Copy to Clipboard</button>";
    echo "<input type='hidden' name='saveContent' value='1'>";
    echo "<button class='btn btn-success' type='submit'>Save Changes</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";

    echo "<div class='log-container alert alert-info'>";
    foreach ($logMessages as $message) {
        echo $message . "<br>";
    }
    echo "</div>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['saveContent'])) {
    if (isset($_POST['configContent'])) {
        $editedContent = trim($_POST['configContent']);
        if (file_put_contents($configFilePath, $editedContent) === false) {
            echo "<div class='log-container alert alert-danger'>Unable to save the modified content to: " . htmlspecialchars($configFilePath) . "</div>";
        } else {
            echo "<div class='log-container alert alert-success'>Content successfully saved to: " . htmlspecialchars($configFilePath) . "</div>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clearData'])) {
    if (file_exists($dataFilePath)) {
        file_put_contents($dataFilePath, '');
        echo "<div class='log-container alert alert-success'>Saved data has been cleared.</div>";
    }
}

if (file_exists($dataFilePath)) {
    $savedData = file_get_contents($dataFilePath);
    echo "<div class='card saved-data-container'>";
    echo "<div class='card-body'>";
    echo "<h2 class='card-title'>Saved data</h2>";
    echo "<pre>" . htmlspecialchars($savedData) . "</pre>";
    echo "<form method='post' action=''>";
    echo "<button class='btn clear-button' type='submit' name='clearData'>Clear data</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
}
            ?>

            <script src="./assets/bootstrap/jquery-3.5.1.slim.min.js"></script>
            <script src="./assets/bootstrap/popper.min.js"></script>
            <script src="./assets/bootstrap/bootstrap.min.css"></script>
            <script>
                function copyToClipboard() {
                    const copyText = document.getElementById("configContent");
                    copyText.select();
                    document.execCommand("copy");
                    alert("Copied to clipboard");
                }
            </script>
        </div>
    </div>
</body>

</html>
