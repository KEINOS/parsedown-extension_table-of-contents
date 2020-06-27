#!/bin/bash
# =============================================================================
#  Test: User defined ToC tag "{:toc}"
# =============================================================================

# Assert equals. Use $NO or $YES
EXPECT_EQUAL=$YES

# Source text in markdown
SOURCE=$(cat << 'HEREDOC'
{:toc}

---

# Head1
Sample text of head 1.
## Head1-1
Sample text of head 1-1.
# Head2
Sample text of head 2.
## 見出し2-1
Sample text of head2-1.
HEREDOC
)

# Expected results("body")
EXPECT=$(cat << 'HEREDOC'
<div id="toc"><ul>
<li><a href="#Head1">Head1</a>
<ul>
<li><a href="#Head1-1">Head1-1</a></li>
</ul></li>
<li><a href="#Head2">Head2</a>
<ul>
<li><a href="#%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</a></li>
</ul></li>
</ul></div>
<hr />
<h1 id="Head1" name="Head1">Head1</h1>
<p>Sample text of head 1.</p>
<h2 id="Head1-1" name="Head1-1">Head1-1</h2>
<p>Sample text of head 1-1.</p>
<h1 id="Head2" name="Head2">Head2</h1>
<p>Sample text of head 2.</p>
<h2 id="%E8%A6%8B%E5%87%BA%E3%81%972-1" name="%E8%A6%8B%E5%87%BA%E3%81%972-1">見出し2-1</h2>
<p>Sample text of head2-1.</p>
HEREDOC
)

# List of method and it's arguments to be executed before "$obj->body()" and "$obj->toc()".
USE_METHODS=$(cat << 'HEREDOC'
[
  {
    "method": "setTagToc",
    "arg": [
      "{:toc}"
    ]
  }
]
HEREDOC
)

# Specify which value to get as a result between "body" and "toc"
# (Default: "toc")
RETURN_VALUE='body'
