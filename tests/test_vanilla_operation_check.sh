#!/bin/bash
# =============================================================================
#  Test of the tests. ;-p  It checks if the $EXPECT_EQUAL bool is working.
# =============================================================================

# Assert equals. Use $NO or $YES
EXPECT_EQUAL=$NO

# Source text in markdown
SOURCE=$(cat << 'HEREDOC'
# WrongHead 1
Sample text of head 1.
## WrongHead 1-1
Sample text of head 1-1.
# WrongHead 2
Sample text of head 2.
## WrongHead 2-1
Sample text of head2-1.
HEREDOC
)

# Expected results("toc")
EXPECT=$(cat << 'HEREDOC'
<ul>
<li><a href="#Head1">Head1</a>
<ul>
<li><a href="#Head1-1">Head1-1</a></li>
</ul></li>
<li><a href="#Head2">Head2</a>
<ul>
<li><a href="#%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</a></li>
</ul></li>
</ul>
HEREDOC
)
