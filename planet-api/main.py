from fastapi import FastAPI
from astroquery.simbad import Simbad
import json

app = FastAPI()


@app.get('/api')
def root():
    return {
        'data': 'root'
    }

@app.get('/api/{planet}')
def return_planet(planet: str):
    pln = Simbad.query_object(planet)
    planet_data = pln.to_pandas().to_dict()

    # Write planet parameters to a JSON file
    with open('C:/xampp2/htdocs/exoplanet-database/src/inits.json', 'w') as file:
        json.dump(planet_data, file)

    return planet_data
