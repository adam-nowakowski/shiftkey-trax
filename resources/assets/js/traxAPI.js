let traxAPI = {
    getCarsEndpoint() {
        return '/api/cars/'
    },
    getAllCarsEndpoint() {
        return '/api/cars/all'
    },
    getCarEndpoint(id) {
        return '/api/cars/show/' + id;
    },
    addCarEndpoint() {
        return '/api/cars/store';
    },
    deleteCarEndpoint(id) {
        return '/api/cars/destroy/' + id;
    },
    getTripsEndpoint() {
        return '/api/trips/';
    },
    addTripEndpoint() {
        return 'api/trips/store'
    }
}

export { traxAPI };
