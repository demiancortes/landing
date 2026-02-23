<title><?php echo htmlspecialchars($businessName); ?><?php if($city) echo " | " . htmlspecialchars($city); ?></title>

<meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">

<meta property="og:title" content="<?php echo htmlspecialchars($businessName); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($metaDescription); ?>">
<meta property="og:image" content="<?php echo $siteUrl . '/preview.jpg'?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo $siteUrl; ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars($businessName); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescription); ?>">
<meta name="twitter:image" content="<?php echo $siteUrl . '/preview.jpg'?>">
