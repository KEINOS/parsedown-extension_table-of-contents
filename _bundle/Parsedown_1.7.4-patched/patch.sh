#!/bin/bash
# =============================================================================
#  Parsedown.php patch script for PHP 8.4
# =============================================================================
#  This script applies a patch to the "_bundle/Parsedown_1.7.4/Parsedown.php"
#  file to avoid deprecation warning of implicit null param usage in PHP 8.4.
#
#  - "Implicitly marking parameter as nullable is deprecated, the explicit
#    nullable type must be used instead." thingy.
# =============================================================================

# Ensure to apply the patch to the correct file
HASH_EXPECTED="af4a4b29f38b5a00b003a3b7a752282274c969e42dee88e55a427b2b61a2f38f"
PATH_DIR_ORIGIN="../Parsedown_1.7.4"
PATH_FILE_PHP_ORIGIN="${PATH_DIR_ORIGIN}/Parsedown.php"
PATH_FILE_LICENSE_ORIGIN="${PATH_DIR_ORIGIN}/LICENSE.txt"

HASH_CURRENT=$(shasum -a 256 "$PATH_FILE_PHP_ORIGIN" | awk '{print $1}')
if [ "$HASH_CURRENT" != "$HASH_EXPECTED" ]; then
    echo "Hash mismatch!"
    echo "  Expected: ${HASH_EXPECTED}"
    echo "  but got : ${HASH_CURRENT}"
fi

# Copy the original file into the current directory
cp "$PATH_FILE_PHP_ORIGIN" ./Parsedown.php
cp "$PATH_FILE_LICENSE_ORIGIN" ./LICENSE.txt

# The patch to apply
PATCH_DATA=$(cat <<'HEREDOC'
--- a/_bundle/Parsedown_1.7.4/Parsedown.php
+++ b/_bundle/Parsedown_1.7.4-patched/Parsedown.php
@@ -2,7 +2,7 @@

 #
 #
-# Parsedown
+# Parsedown (patched)
 # http://parsedown.org
 #
 # (c) Emanuil Rusev
@@ -17,7 +17,7 @@ class Parsedown
 {
     # ~

-    const version = '1.7.4';
+    const version = '1.7.4-patched';

     # ~

@@ -712,7 +712,7 @@ class Parsedown
     #
     # Setext

-    protected function blockSetextHeader($Line, array $Block = null)
+    protected function blockSetextHeader($Line, ?array $Block = null)
     {
         if ( ! isset($Block) or isset($Block['type']) or isset($Block['interrupted']))
         {
@@ -850,7 +850,7 @@ class Parsedown
     #
     # Table

-    protected function blockTable($Line, array $Block = null)
+    protected function blockTable($Line, ?array $Block = null)
     {
         if ( ! isset($Block) or isset($Block['type']) or isset($Block['interrupted']))
         {
HEREDOC
)

# Apply the patch with appropriate -p level so that the patched file name is just "Parsedown.php"
echo "$PATCH_DATA" | patch -p3 ./Parsedown.php
shasum -a 256 --tag Parsedown.php > ./Parsedown.php.sha256
echo "Patched file saved as ./Parsedown.php"
