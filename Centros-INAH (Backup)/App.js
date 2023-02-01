import { StatusBar } from 'expo-status-bar';
import { SafeAreaView } from 'react-native-safe-area-context';
import { StyleSheet, Text, View } from 'react-native';
import StackNavigator from './Screens/StackNavigator';

export default function App() {
  return (
    <StackNavigator />
  );
}