let traxAPI = {
    getCarsEndpoint() {
        return '/api/cars/'
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
        return '/api/mock-get-trips';
    },
    addTripEndpoint() {
        return 'api/mock-add-trip'
    }
}

export { traxAPI };
