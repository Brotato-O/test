<?php

/**
 * FPDF Installation Helper Script
 * 
 * This script checks if FPDF is installed and attempts to install it if not found.
 */

// Define the target directory for FPDF installation
$vendorDir = __DIR__ . '/../../vendor';
$fpdfDir = $vendorDir . '/fpdf';

// Create vendor directory if it doesn't exist
if (!file_exists($vendorDir)) {
    mkdir($vendorDir, 0777, true);
    echo "Created vendor directory: $vendorDir<br>";
}

// Check if FPDF is already installed
if (file_exists($fpdfDir . '/fpdf.php')) {
    echo "<div style='background-color:#CCFFCC; padding:10px; margin:10px; border:1px solid #00CC00;'>";
    echo "<h3>FPDF is already installed</h3>";
    echo "<p>FPDF library found at: $fpdfDir/fpdf.php</p>";
    echo "</div>";
} else {
    // Download FPDF
    echo "<h3>Installing FPDF...</h3>";

    // Create fpdf directory
    if (!file_exists($fpdfDir)) {
        mkdir($fpdfDir, 0777, true);
        echo "Created fpdf directory: $fpdfDir<br>";
    }

    // Download FPDF from fpdf.org
    $fpdfUrl = 'http://www.fpdf.org/en/dl.php?v=184&f=tgz';
    $tempFile = tempnam(sys_get_temp_dir(), 'fpdf');

    if (function_exists('curl_init')) {
        $ch = curl_init($fpdfUrl);
        $fp = fopen($tempFile, 'w');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        echo "Downloaded FPDF using curl<br>";
    } elseif (ini_get('allow_url_fopen')) {
        file_put_contents($tempFile, file_get_contents($fpdfUrl));
        echo "Downloaded FPDF using file_get_contents<br>";
    } else {
        echo "<div style='background-color:#FFCCCC; padding:10px; margin:10px; border:1px solid #FF0000;'>";
        echo "<h3>Error: Cannot download FPDF</h3>";
        echo "<p>Both curl and allow_url_fopen are disabled. Please manually download FPDF from <a href='http://www.fpdf.org/'>http://www.fpdf.org/</a> and extract it to: $fpdfDir</p>";
        echo "</div>";
        exit;
    }

    // Extract the downloaded file
    echo "Extracting FPDF...<br>";

    // Check if we can use PharData for extraction
    if (class_exists('PharData')) {
        try {
            $phar = new PharData($tempFile);
            $phar->extractTo($vendorDir);
            echo "Extracted using PharData<br>";

            // Move files from the extracted directory to fpdf directory
            $extractedDir = $vendorDir . '/fpdf184';
            if (file_exists($extractedDir)) {
                // Copy files from extracted directory to target fpdf directory
                copy_directory($extractedDir, $fpdfDir);
                // Remove the extracted directory
                delete_directory($extractedDir);
                echo "Moved files to the correct location<br>";
            }
        } catch (Exception $e) {
            echo "Error extracting: " . $e->getMessage() . "<br>";
            manual_instructions($fpdfUrl, $fpdfDir);
            exit;
        }
    } else {
        manual_instructions($fpdfUrl, $fpdfDir);
        exit;
    }

    // Check if FPDF was successfully installed
    if (file_exists($fpdfDir . '/fpdf.php')) {
        echo "<div style='background-color:#CCFFCC; padding:10px; margin:10px; border:1px solid #00CC00;'>";
        echo "<h3>FPDF installed successfully!</h3>";
        echo "<p>FPDF library is now available at: $fpdfDir/fpdf.php</p>";
        echo "<p>You can now use the 'In hóa đơn' button in the order list.</p>";
        echo "</div>";
    } else {
        manual_instructions($fpdfUrl, $fpdfDir);
    }
}

// Helper function to display manual installation instructions
function manual_instructions($fpdfUrl, $fpdfDir)
{
    echo "<div style='background-color:#FFCCCC; padding:10px; margin:10px; border:1px solid #FF0000;'>";
    echo "<h3>Automatic installation failed</h3>";
    echo "<p>Please follow these steps to install FPDF manually:</p>";
    echo "<ol>";
    echo "<li>Download FPDF from <a href='http://www.fpdf.org/' target='_blank'>http://www.fpdf.org/</a></li>";
    echo "<li>Extract the downloaded file</li>";
    echo "<li>Copy the files to: $fpdfDir</li>";
    echo "<li>Ensure that $fpdfDir/fpdf.php exists</li>";
    echo "</ol>";
    echo "</div>";
}

// Helper function to copy a directory recursively
function copy_directory($source, $dest)
{
    if (!is_dir($dest)) {
        mkdir($dest, 0777, true);
    }

    $dir = opendir($source);
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $srcFile = "$source/$file";
            $destFile = "$dest/$file";

            if (is_dir($srcFile)) {
                copy_directory($srcFile, $destFile);
            } else {
                copy($srcFile, $destFile);
            }
        }
    }
    closedir($dir);
}

// Helper function to delete a directory recursively
function delete_directory($dir)
{
    if (!is_dir($dir)) {
        return;
    }

    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = "$dir/$file";
        is_dir($path) ? delete_directory($path) : unlink($path);
    }
    return rmdir($dir);
}
