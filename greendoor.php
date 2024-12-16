<?php
// Start the session to store user choices
session_start();

// Handle user choices and progress the story
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $choice = $_POST['choice'] ?? null;
    $_SESSION['story'][] = $choice;
} else {
    $_SESSION['story'] = []; // Reset story for a new session
}

// Define the story branches
$story = [
    'start' => [
        'text' => "You find yourself in a dark, haunted forest. The trees tower over you, their twisted branches reaching out like claws. Strange noises echo through the mist, and you sense movement in the shadows. Do you...",
        'choices' => [
            'explore' => "Explore deeper into the forest",
            'hide' => "Find a place to hide"
        ]
    ],
    'explore' => [
        'text' => "You venture deeper into the forest, your heart pounding. Suddenly, you hear growling nearby. You see a pair of glowing eyes staring at you. Do you...",
        'choices' => [
            'run' => "Run away",
            'confront' => "Stand your ground and confront the creature"
        ]
    ],
    'hide' => [
        'text' => "You crouch behind a large tree, trying to steady your breath. The growling gets closer, and you notice a wild wolf sniffing the air. Do you...",
        'choices' => [
            'climb' => "Climb the tree to stay safe",
            'distract' => "Throw a rock to distract the wolf"
        ]
    ],
    'run' => [
        'text' => "You sprint through the forest, branches whipping against your face. You stumble upon an old abandoned cabin. Do you...",
        'choices' => [
            'enter' => "Enter the cabin",
            'keep_running' => "Keep running into the forest"
        ]
    ],
    'confront' => [
        'text' => "You stand your ground, and the creature steps forward, revealing itself to be a wild bear. Luckily, it seems more curious than aggressive. You slowly back away and find a narrow path leading out of the forest. The End.",
        'choices' => []
    ],
    'climb' => [
        'text' => "You climb the tree just as the wolf reaches the base. From your vantage point, you spot a clearing in the distance. You wait until the wolf leaves and make your way to safety. The End.",
        'choices' => []
    ],
    'distract' => [
        'text' => "You throw a rock, and the wolf chases after the noise. Seizing the opportunity, you run and discover an old, overgrown trail that leads you out of the forest. The End.",
        'choices' => []
    ],
    'enter' => [
        'text' => "You enter the cabin and find it filled with strange symbols and an old lantern. Lighting the lantern reveals a hidden map that shows a way out of the forest. The End.",
        'choices' => []
    ],
    'keep_running' => [
        'text' => "You keep running, but the forest seems endless. Exhausted, you stumble upon a group of friendly campers who help you find your way back. The End.",
        'choices' => []
    ]
];

// Determine the current part of the story
$current = 'start';
foreach ($_SESSION['story'] as $choice) {
    if (isset($story[$choice])) {
        $current = $choice;
    }
}

// Display the current part of the story
$current_story = $story[$current];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Story</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image:  url('bggreen.jpg');
            background-size: cover; /* Makes the image cover the entire background */
    background-repeat: no-repeat; /* Prevents the image from repeating */
    background-position: center; /* Centers the image */
        }
        .story-container {
            max-width: 600px;
            background: #63cd81;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .choices {
            margin-top: 20px;
        }
        .choices button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .choices button:hover {
            background-color: #2980b9;
        }
        .back-button {
            margin-top: 20px;
            text-decoration: none;
            color: #1e1e2f;
            background-color: #3498db;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="story-container">
        <p><?php echo $current_story['text']; ?></p>

        <?php if (!empty($current_story['choices'])): ?>
            <form method="POST" class="choices">
                <?php foreach ($current_story['choices'] as $key => $label): ?>
                    <button type="submit" name="choice" value="<?php echo $key; ?>">
                        <?php echo $label; ?>
                    </button>
                <?php endforeach; ?>
            </form>
        <?php else: ?>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="back-button">Start Over</a>
        <?php endif; ?>
    </div>
    <a href="index.html" class="back-button">Go Back</a>
</body>
</html>
