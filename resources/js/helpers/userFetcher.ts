export function fetchLogedInUser() {
    const userString = sessionStorage.getItem('user');
    if (!userString) {
        return null;
    }
  
    return JSON.parse( userString );
}