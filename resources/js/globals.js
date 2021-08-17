import {getToken} from "./src/lib/utils";
import axios from 'axios';
import moment from "moment-timezone";


moment.tz.setDefault('Asia/Tokyo');
moment['suppressDeprecationWarnings'] = true;

axios.defaults.headers.common['Authorization'] = 'Bearer ' + getToken();
axios.defaults.baseURL = '/api';
axios.defaults.responseType = 'json';
