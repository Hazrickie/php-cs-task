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
        'text' => "You just arrive home after a long day. As you step inside, you notice something different. Do you...",
        'choices' => [
            'inspect' => "Inspect the living room for changes",
            'relax' => "Head straight to the couch to relax"
        ]
    ],
    'inspect' => [
        'text' => "You walk into the living room and notice a beautifully wrapped gift on the coffee table. Do you...",
        'choices' => [
            'open' => "Open the gift",
            'wait' => "Wait for someone to arrive before opening it"
        ]
    ],
    'relax' => [
        'text' => "You sink into the couch, feeling a sense of peace. Just then, you hear footsteps approaching. Do you...",
        'choices' => [
            'greet' => "Get up to greet whoever it is",
            'stay' => "Stay on the couch and wait"
        ]
    ],
    'open' => [
        'text' => "You open the gift and find a heartfelt letter from a loved one, thanking you for all you do. It warms your heart. The End.",
        'choices' => []
    ],
    'wait' => [
        'text' => "You decide to wait. Moments later, your family arrives and surprises you with a small celebration. The End.",
        'choices' => []
    ],
    'greet' => [
        'text' => "You get up and are greeted by a dear friend who has come to visit you unexpectedly. You spend the evening chatting and laughing. The End.",
        'choices' => []
    ],
    'stay' => [
        'text' => "You stay on the couch, and a pet hops up beside you, curling up for a nap. It's a quiet, peaceful evening. The End.",
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
            background-image: url('bgred.jpg');
            background-size: cover; /* Makes the image cover the entire background */
    background-repeat: no-repeat; /* Prevents the image from repeating */
    background-position: center; /* Centers the image */
        }
        .story-container {
            max-width: 600px;
            background: #ffffff;
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
