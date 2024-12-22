# 🔐 **RSA Factorization Web Application**  

This project is a simple web application designed to explore the factorization of a large composite number into its two prime factors, which is a core aspect of cracking the one-way function in the **RSA algorithm**. The application takes a large composite number as input and factors it into two large prime numbers, providing results with multiple factorization methods, iterations, and time comparison graphs.  

---

## 🌟 **Features**  

- **Input for Factorization**:  
  - Allows users to enter a large composite number to be factorized into two prime numbers.  
- **Factorization Methods**:  
  - **Fermat's Factorization**: A method that works by finding factors through difference of squares.  
  - **Trial Division**: A straightforward method that divides the number by integers starting from 2 upwards.  
  - **Pollard's Rho Algorithm**: A more efficient probabilistic method to find factors of large numbers.  
- **Time Comparison Graph**:  
  - Graphical representation of the time taken for each factorization method.  
- **Iterations**:  
  - Shows the number of iterations performed for each method to factorize the given number.  

---

## 🔧 **Technologies Used**  

- **Frontend**:  
  - HTML5  
  - CSS3  
- **Backend**:  
  - PHP (for processing the factorization)  

---

## 🚀 **How to Run the Project**  

1. Clone this repository to your local machine:  
   ```bash
   git clone https://github.com/Jenson073/rsa-factorization-web-app.git
2. Ensure you have a local server like XAMPP or WAMP installed.
3. Place the project files in the server's root directory (e.g., htdocs for XAMPP).
4. Enter a large composite number, click "Factorize," and explore the results with different factorization methods and time comparisons.

---
