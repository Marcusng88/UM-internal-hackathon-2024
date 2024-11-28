from flask import Flask, request, redirect, render_template
import csv
import os

app = Flask(__name__)

@app.route('/')
def feedback_form():
    return render_template('feedback.html')

@app.route('/submit_feedback', methods=['POST'])
def submit_feedback():
    food_quality = request.form.get('foodQuality')
    food_temperature = request.form.get('foodTemperature')
    menu_variety = request.form.get('menuVariety')
    taste_flavor = request.form.get('tasteFlavor')
    premium_options = request.form.get('premiumOptions')
    comments = request.form.get('comments')

    # Save the feedback to a CSV file
    file_exists = os.path.isfile('feedback.csv')
    with open('feedback.csv', 'a', newline='') as csvfile:
        fieldnames = ['food_quality', 'food_temperature', 'menu_variety', 'taste_flavor', 'premium_options', 'comments']
        writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
        if not file_exists:
            writer.writeheader()
        writer.writerow({
            'food_quality': food_quality,
            'food_temperature': food_temperature,
            'menu_variety': menu_variety,
            'taste_flavor': taste_flavor,
            'premium_options': premium_options,
            'comments': comments
        })

    # Redirect to the thank you page
    return redirect('/feedbacktq')

@app.route('/feedbacktq')
def feedback_thank_you():
    return render_template('feedbacktq.html')

if __name__ == '__main__':
    app.run(debug=True)