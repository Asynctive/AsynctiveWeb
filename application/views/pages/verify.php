<?php if(isset($email_verified) && $email_verified == TRUE): ?>
<h3>Verified</h3>

<p>Your account has been successfully verified.</p>
<?php else: ?>
<h3>Verification Failed</h3>

<p>There was an issue verifying you</p>
<?php endif ?>