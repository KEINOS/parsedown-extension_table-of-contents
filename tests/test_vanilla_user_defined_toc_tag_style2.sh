#!/bin/bash
# =============================================================================
#  Test: Basic parsing
# =============================================================================

EXPECT_EQUAL=$YES # Use $NO or $YES

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

RETURN_VALUE='body' # "body" or "toc". Default: "toc"
