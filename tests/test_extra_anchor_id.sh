#!/bin/bash
# =============================================================================
#  Test: Anchor ID of Parsedown Extra (See PR #16)
# =============================================================================

EXPECT_EQUAL=$YES # Use $NO or $YES

SOURCE=$(cat << 'HEREDOC'
# Head1
Sample text of head 1.
## Head1-1
Sample text of head 1-1.
# Head2
Sample text of head 2.
## 見出し2-1
Sample text of head2-1.
# Head3 {#self-defined-head3}
Sample text of head 3
HEREDOC
)

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
<li><a href="#self-defined-head3">Head3</a></li>
</ul>
HEREDOC
)
