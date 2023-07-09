// Post Like START
document.querySelectorAll(".like-button").forEach(async (button) => {
    button.addEventListener("click", async function () {
      const postId = this.dataset.postId;
      const icon = this.querySelector("i");
      const loader = this.querySelector(".loader");
  
      // Show the loader
      loader.classList.add("show");
  
      try {
        const response = await axios.post(`/posts/${postId}/like`);
  
        // Handle the response
        if (response) {
          // Update the icon class
          if ([...icon.classList].includes("far")) {
            icon.classList.remove("far");
            icon.classList.add("fas");
          } else {
            icon.classList.add("far");
            icon.classList.remove("fas");
          }
        }
      } catch (error) {
        // Handle any errors
        alert(error.response.data.message);
      } finally {
        // Hide the loader
        loader.classList.remove("show");
      }
    });
  });
// Post Like END
