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
        'text' => "You find yourself standing before a heavy wooden door, slightly ajar. Curiosity gets the better of you, and you step inside. The room is dimly lit, with strange shadows flickering on the walls. Do you...",
        'choices' => [
            'explore' => "Explore the room",
            'stay' => "Stay near the door"
        ]
    ],
    'explore' => [
        'text' => "You walk deeper into the room, noticing peculiar artifacts scattered across a table. One of them glows faintly. Do you...",
        'choices' => [
            'inspect' => "Inspect the glowing artifact",
            'ignore' => "Ignore it and look around the room"
        ]
    ],
    'stay' => [
        'text' => "You decide to stay near the door, listening carefully. You hear faint whispers coming from the shadows. Do you...",
        'choices' => [
            'investigate' => "Investigate the whispers",
            'leave' => "Step back out of the room"
        ]
    ],
    'inspect' => [
        'text' => "You pick up the glowing artifact. As you hold it, the room brightens, revealing ancient symbols on the walls. The artifact feels warm in your hands, and you sense it holds great power. The End.",
        'choices' => []
    ],
    'ignore' => [
        'text' => "You decide to ignore the artifact and continue exploring. You find a hidden door behind a curtain, leading to another mysterious chamber. The End.",
        'choices' => []
    ],
    'investigate' => [
        'text' => "You step toward the shadows, and the whispers grow louder. Suddenly, a figure emerges, offering you a choice: leave now or learn the room's secrets. The End.",
        'choices' => []
    ],
    'leave' => [
        'text' => "Feeling uneasy, you decide to leave the room. As you step outside, the door slams shut behind you, locking its mysteries away. The End.",
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
            background-image:  url('bgblue.jpg');
            background-size: cover; /* Makes the image cover the entire background */
    background-repeat: no-repeat; /* Prevents the image from repeating */
    background-position: center; /* Centers the image */
        }
        .story-container {
            max-width: 600px;
            background: grey;
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
