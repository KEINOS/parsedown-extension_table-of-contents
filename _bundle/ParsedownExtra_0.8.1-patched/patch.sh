#!/bin/bash
# =============================================================================
#  ParsedownExtra.php patch script for PHP 8.2 and later
# =============================================================================
#  This script applies a patch to the following file to avoid deprecation
#  warnings from PHP 8.2+ and 8.4+:
#    "_bundle/ParsedownExtra_0.8.1/ParsedownExtra.php"
#
#  - PHP 8.2 fix:
#    "Handling HTML entities via mbstring is deprecated, htmlspecialchars,
#    htmlentities, or mb_encode_numericentity/mb_decode_numericentity must be
#    used instead"
#  - PHP 8.4 fix:
#    "Implicitly marking parameter as nullable is deprecated, the explicit
#    nullable type must be used instead."
# =============================================================================

# Ensure to apply the patch to the correct file
HASH_EXPECTED="b0c6bd5280fc7dc1caab4f4409efcae9fb493823826f7999c27b859152494be7"
PATH_DIR_ORIGIN="../ParsedownExtra_0.8.1"
PATH_FILE_PHP_ORIGIN="${PATH_DIR_ORIGIN}/ParsedownExtra.php"
PATH_FILE_LICENSE_ORIGIN="${PATH_DIR_ORIGIN}/LICENSE.txt"

HASH_CURRENT=$(shasum -a 256 "$PATH_FILE_PHP_ORIGIN" | awk '{print $1}')
if [ "$HASH_CURRENT" != "$HASH_EXPECTED" ]; then
    echo "Hash mismatch!"
    echo "  Expected: ${HASH_EXPECTED}"
    echo "  but got : ${HASH_CURRENT}"
fi

# Copy the original file into the current directory
cp "$PATH_FILE_PHP_ORIGIN" ./ParsedownExtra.php
cp "$PATH_FILE_LICENSE_ORIGIN" ./LICENSE.txt

# The patch to apply
PATCH_DATA=$(cat <<'HEREDOC'
--- a/_bundle/ParsedownExtra_0.8.1/ParsedownExtra.php
+++ b/_bundle/ParsedownExtra_0.8.1-patched/ParsedownExtra.php
@@ -17,7 +17,7 @@ class ParsedownExtra extends Parsedown
 {
     # ~

-    const version = '0.8.1';
+    const version = '0.8.1-patched';

     # ~

@@ -238,7 +238,7 @@ class ParsedownExtra extends Parsedown
     #
     # Setext

-    protected function blockSetextHeader($Line, array $Block = null)
+    protected function blockSetextHeader($Line, ?array $Block = null)
     {
         $Block = parent::blockSetextHeader($Line, $Block);

@@ -477,7 +477,14 @@ class ParsedownExtra extends Parsedown
         $DOMDocument = new DOMDocument;

         # http://stackoverflow.com/q/11309194/200145
-        $elementMarkup = mb_convert_encoding($elementMarkup, 'HTML-ENTITIES', 'UTF-8');
+        # https://github.com/symfony/symfony/pull/46221/files
+        $convmap = [
+            0x80,     // beginning of the code point range
+            0x10FFFF, // maximum code point allowed by UTF-8
+            0,        // offset = none
+            0xFFFF    // mask of the converted code point
+        ];
+        $elementMarkup = mb_encode_numericentity($elementMarkup, $convmap, 'UTF-8');

         # http://stackoverflow.com/q/4879946/200145
         $DOMDocument->loadHTML($elementMarkup);

HEREDOC
)

# Apply the patch with appropriate -p level so that the patched file name is just
# "ParsedownExtra.php"
echo "$PATCH_DATA" | patch -p3 ./ParsedownExtra.php
shasum -a 256 --tag ParsedownExtra.php > ./ParsedownExtra.php.sha256
echo "Patched file saved as ./ParsedownExtra.php"
