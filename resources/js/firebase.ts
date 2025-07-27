import { initializeApp, getApps } from 'firebase/app';
import {
  getAuth,
  GoogleAuthProvider,
  setPersistence,
  browserLocalPersistence,
  signInWithPopup,
} from 'firebase/auth';
import {getFirestore} from "firebase/firestore";
import { getDatabase } from 'firebase/database'

const firebaseConfig = {
  apiKey: "AIzaSyChVVv2AuwL9Fv-quOOneUj8cHw-7a9zAc",
  authDomain: "zo-stream-f04ea.firebaseapp.com",
  databaseURL: "https://zo-stream-f04ea-default-rtdb.firebaseio.com",
  projectId: "zo-stream-f04ea",
  storageBucket: "zo-stream-f04ea.appspot.com",
  messagingSenderId: "164125430857",
  appId: "1:164125430857:web:0c10b3f8c1b1ff3494db98",
  measurementId: "G-YET348Q25X"
};

// ✅ Only initialize Firebase if it hasn't been already
const app = getApps().length === 0 ? initializeApp(firebaseConfig) : getApps()[0];
const auth = getAuth(app);
setPersistence(auth, browserLocalPersistence);

const googleProvider = new GoogleAuthProvider();
const db = getFirestore(app);
const rdb = getDatabase(app)

export { auth, googleProvider, signInWithPopup, db, rdb };
