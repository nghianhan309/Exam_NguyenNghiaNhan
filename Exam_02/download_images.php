<?php
$urls = [
    "https://images.unsplash.com/photo-1544108182-8810058c3a7d?q=80&w=200&auto=format&fit=crop", // Router
    "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=200&auto=format&fit=crop", // Switch/Server
    "https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?q=80&w=200&auto=format&fit=crop", // Playstation/Device
    "https://images.unsplash.com/photo-1593640408182-31c70c8268f5?q=80&w=200&auto=format&fit=crop", // Server PC
    "https://images.unsplash.com/photo-1551739440-5dd934d3a94a?q=80&w=200&auto=format&fit=crop", // IT equipment
    "https://images.unsplash.com/photo-1557800636-894a64c1696f?q=80&w=200&auto=format&fit=crop", // Camera
    "https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=200&auto=format&fit=crop", // Lock/Smart Home
    "https://images.unsplash.com/photo-1550989460-0adf9ea622e2?q=80&w=200&auto=format&fit=crop", // Light/Smart Home
    "https://images.unsplash.com/photo-1543512214-318c7553f230?q=80&w=200&auto=format&fit=crop", // Speaker
    "https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=200&auto=format&fit=crop", // Microchip/Robot
    "https://images.unsplash.com/photo-1527443195645-1133f7f28990?q=80&w=200&auto=format&fit=crop", // Display/Monitor
    "https://images.unsplash.com/photo-1517055747514-a901004bb1da?q=80&w=200&auto=format&fit=crop"  // Projector/Lens
];

for ($i = 0; $i < count($urls); $i++) {
    $num = $i + 1;
    $ch = curl_init($urls[$i]);
    $fp = fopen("assets/images/img$num.jpg", 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}
echo "Downloaded successfully!";
?>
