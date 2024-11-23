<?php

    class ReviewsController extends Controller {

        /**
         * Adds a review (comment) for a movie.
         * 
         * @return void
         */
        public function addReview() {
            // Check if user_id and movie_id are passed via POST
            if (isset($_POST['user_id']) && isset($_POST['movie_id'])) {
                
                $user_id = $_POST['user_id'];
                $movie_id = $_POST['movie_id'];
                $comment = $_POST['comment'];
                $rating = $_POST['rating'] ?? 0;
                
                $reviewModel = new Review();

                // Check if the user has already reviewed this movie
                if ($reviewModel->inReviews($user_id, $movie_id)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'You have already reviewed this movie.'
                    ]);
                    return;
                }
                
                if (
                    $reviewModel->addReview(
                        $user_id, 
                        $movie_id, 
                        $comment,
                        $rating
                    )
                ){
                    echo json_encode([
                        'success' => true,
                        'message' => 'Review Added Successfully.'
                    ]);
                }
                else{
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to add review.'
                    ]);
                }
            } else {
                // Missing parameters
                echo json_encode([
                    'success' => false,
                    'message' => 'Missing Arguments.'
                ]);
            }
        }

        /**
         * Allows users to delete their reviews.
         * @param int $userId User ID
         * @param int $movieId Movie ID
         * 
        */
        public function deleteReview() {
            
            // Check if review_id is passed via POST
            if (isset($_POST['review_id'])) {

                $review_id = $_POST['review_id'];
        
                $reviewModel = new Review();
        
                // Proceed to delete the review
                if ($reviewModel->deleteReview($review_id)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Review deleted successfully.'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to delete review.'
                    ]);
                }
            } else {
                // Missing parameters
                echo json_encode([
                    'success' => false,
                    'message' => 'Missing Arguments.'
                ]);
            }
        }        

}
