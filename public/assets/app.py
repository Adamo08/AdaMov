import os

# Define the relative path to the folder where the videos are located
folder_path = './public/assets/videos'

# List of new names for the videos, in the desired order
new_names = [
    "hood", "agent", "love_crosses", "sail_of_fate", "bloodfist",
    "baseball_tournament", "basketball_tournament", "a_man_with_black_hat",
    "katana", "another_planet", "lionhearted_warrior", "beyond_horizons", 
    "the_jungle_watcher", "night_party", "fauget", "driving_into_darkness", 
    "mystic_of_castle", "the_great_mansion", "coming_soon", "scary_house", 
    "lights_out", "cosmos", "halloween", "ang_unang_aswang", "shadow_door", 
    "dark","multo"
]


# Define the file extension (e.g., ".mp4" or ".mkv")
file_extension = '.mp4'

# Loop through each file number and rename it to the corresponding name
for i, new_name in enumerate(new_names, start=1):
    # Construct the original file name (e.g., '1.mp4', '2.mp4', ...)
    original_file = "/".join([folder_path, f"{i}{file_extension}"])
    # Construct the new file name with the given names
    new_file = "/".join([folder_path, f"{new_name}{file_extension}"])
    
    # Rename the file
    try:
        os.rename(original_file, new_file)
        print(f"Renamed '{original_file}' to '{new_file}'")
    except FileNotFoundError:
        print(f"File '{original_file}' not found, skipping.")
    except Exception as e:
        print(f"Error renaming '{original_file}' to '{new_file}': {e}")

