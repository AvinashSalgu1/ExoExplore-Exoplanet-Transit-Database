import requests
import json

# Define the API endpoint URL
url = 'https://exoplanetarchive.ipac.caltech.edu/cgi-bin/nstedAPI/nph-nstedAPI'

# Define parameters for the API request (e.g., selecting columns and filters)
params = {
    'table': 'ML',  # Corrected table name
    'format': 'json',
    'select': 'pl_name,pl_hostname,pl_discmethod,pl_orbper,pl_orbsmax',
    'where': 'pl_discmethod="Radial Velocity"'
}

# Send the API request and get the response
response = requests.get(url, params=params)
print(response.content)

# Check if the request was successful
if response.status_code == 200:
    # Check if response content is not empty
    if response.content:
        try:
            # Parse the JSON response
            data = response.json()
            
            # Define the filename for the new JSON file
            filename = 'exoplanet_data.json'
            
            # Write the data to the JSON file
            with open(filename, 'w') as f:
                json.dump(data, f, indent=4)
                
            print(f'Data has been successfully dumped to {filename}.')
        except json.JSONDecodeError:
            print('Failed to parse JSON. Response content is not in valid JSON format.')
    else:
        print('Response content is empty.')
else:
    print('Failed to retrieve data. Status code:', response.status_code)
