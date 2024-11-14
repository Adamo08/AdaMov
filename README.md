---

### Controllers

Each controller will handle specific actions related to its area, interacting with models to retrieve data and directing that data to views.

1. **HomeController**
   - **Actions**:
     - `index`: Loads the homepage with featured and trending movies.
     - `about`: Displays an “About Us” page with details about the site.

2. **MoviesController**
   - **Actions**:
     - `index`: Shows a list of movies, possibly with filters (e.g., genre, release date).
     - `show`: Shows detailed information about a single movie.
     - `filterByGenre`: Filters movies by selected genre.
     - `filterByRating`: Filters movies by rating or popularity.
   
3. **GenresController**
   - **Actions**:
     - `index`: Lists all available genres for browsing.
     - `show`: Displays movies within a specific genre.

4. **SearchController**
   - **Actions**:
     - `search`: Processes search queries and displays matching movies.

5. **AuthController** (Handles user registration, login, and logout)
   - **Actions**:
     - `login`: Displays and processes the login form.
     - `register`: Displays and processes the registration form.
     - `logout`: Logs the user out of the site.
     - `profile`: Shows and allows edits to the user’s profile (e.g., favorite movies, watched history).

6. **ReviewsController**
   - **Actions**:
     - `create`: Allows users to add reviews for movies.
     - `edit`: Allows users to edit their existing reviews.
     - `delete`: Allows users to delete their reviews.
     - `index`: Shows all reviews for a particular movie.

7. **CommentsController**
   - **Actions**:
     - `create`: Allows users to add comments on movie reviews or blog posts.
     - `delete`: Allows users to delete their own comments.
     - `edit`: Allows users to edit their comments.

8. **FavoritesController**
   - **Actions**:
     - `index`: Shows the user’s list of favorite movies.
     - `add`: Adds a movie to the user's favorites.
     - `remove`: Removes a movie from the user's favorites.

9. **RatingsController**
   - **Actions**:
     - `rateMovie`: Allows users to rate a movie and store/update the rating.
     - `updateRating`: Updates the user’s rating for a movie.

10. **AdminController**
    - **Actions**:
      - `dashboard`: Shows admin statistics (e.g., total movies, users, recent reviews).
      - `manageMovies`: CRUD operations for managing movies.
      - `manageGenres`: CRUD operations for managing genres.
      - `manageUsers`: CRUD operations for managing user accounts.
      - `manageReviews`: Manage user reviews and moderate if necessary.

---

### Models

Each model will represent a specific table or set of related data and contain methods for data operations.

1. **Movie**
   - **Methods**:
     - `getAllMovies`: Fetches all movies.
     - `getMovieById`: Fetches a single movie by ID.
     - `getTrendingMovies`: Fetches movies based on ratings or popularity.
     - `filterByGenre`: Returns movies filtered by genre.
     - `filterByReleaseDate`: Fetches movies released within a certain timeframe.
     - `addMovie`: Adds a new movie (admin-only).
     - `deleteMovie`: Deletes a movie by ID (admin-only).
     - `updateMovie`: Updates movie details (admin-only).

2. **Genre**
   - **Methods**:
     - `getAllGenres`: Fetches all genres.
     - `getMoviesByGenre`: Fetches movies for a specific genre.
     - `addGenre`: Adds a new genre (admin-only).
     - `deleteGenre`: Deletes a genre (admin-only).
     - `updateGenre`: Updates genre details (admin-only).

3. **User**
   - **Methods**:
     - `registerUser`: Registers a new user with hashed passwords.
     - `loginUser`: Authenticates a user and creates a session.
     - `logoutUser`: Logs out the user by destroying the session.
     - `getUserById`: Fetches a user by their ID.
     - `updateProfile`: Updates the user’s profile information.
     - `getFavorites`: Fetches the user’s list of favorite movies.
   
4. **Review**
   - **Methods**:
     - `getAllReviewsByMovie`: Fetches all reviews for a particular movie.
     - `getUserReviews`: Fetches reviews written by a specific user.
     - `addReview`: Adds a new review to a movie.
     - `editReview`: Edits an existing review by the user.
     - `deleteReview`: Deletes a review by ID.

5. **Comment**
   - **Methods**:
     - `getCommentsByReview`: Fetches all comments for a particular review.
     - `addComment`: Adds a comment to a review.
     - `editComment`: Edits an existing comment by the user.
     - `deleteComment`: Deletes a comment by ID.

6. **Favorite**
   - **Methods**:
     - `getFavoritesByUser`: Fetches all favorite movies for a user.
     - `addFavorite`: Adds a movie to the user’s favorites.
     - `removeFavorite`: Removes a movie from the user’s favorites.

7. **Rating**
   - **Methods**:
     - `getRatingByUserAndMovie`: Fetches the rating a user gave a particular movie.
     - `addRating`: Adds a new rating for a movie.
     - `updateRating`: Updates the user’s rating for a movie.
     - `calculateAverageRating`: Calculates the average rating for a movie.

8. **Admin** (optional if you have admin-specific functionalities)
   - **Methods**:
     - `getSiteStatistics`: Fetches site-wide statistics (e.g., total movies, reviews, users).
     - `getRecentReviews`: Fetches recent reviews for moderation.
     - `getAllUsers`: Fetches all users.
     - `deleteUser`: Deletes a user by ID.

---

### Example Directory Structure (Expanded)

This project structure helps keep your code organized and follows the MVC pattern effectively.

```plaintext
project_root/
├── assets/
├── config/
│   └── config.php
├── controllers/
│   ├── HomeController.php
│   ├── MoviesController.php
│   ├── GenresController.php
│   ├── SearchController.php
│   ├── AuthController.php
│   ├── ReviewsController.php
│   ├── CommentsController.php
│   ├── FavoritesController.php
│   ├── RatingsController.php
│   └── AdminController.php
├── models/
│   ├── Movie.php
│   ├── Genre.php
│   ├── User.php
│   ├── Review.php
│   ├── Comment.php
│   ├── Favorite.php
│   ├── Rating.php
│   └── Admin.php
├── views/
│   ├── layouts/
│   ├── home.php
│   ├── movie_details.php
│   ├── search_results.php
│   ├── login.php
│   ├── register.php
│   └── admin/
├── index.php
└── .htaccess
```

### Next Steps
Each controller and model can be built incrementally. Start with core models (like `Movie` and `Genre`), then move on to user-focused features like `Reviews` and `Favorites`. Add `Auth` and `Admin` last, as these will likely require more security and role-based access control.