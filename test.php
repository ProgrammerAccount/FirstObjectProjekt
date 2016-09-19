<?php
echo htmlentities("źółć",ENT_SUBSTITUTE)."   htmlentities<br/>";
echo htmlspecialchars("<br/>",ENT_DISALLOWED)."   htmlspecialchars";
?>