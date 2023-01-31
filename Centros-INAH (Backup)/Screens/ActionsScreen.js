import { StatusBar } from 'expo-status-bar';
import { SafeAreaView } from 'react-native-safe-area-context';
import { StyleSheet, Text, TouchableOpacity, View, Image} from 'react-native';

export default function ActionsScreen({navigation}) {
  return (
    <SafeAreaView style={styles.mainContainer}>
        <Image
            style={{width: 100, height: 100, marginBottom: 20,  backgroundColor: 'white', borderRadius: 10}}
            source={require('../assets/INAH-Logo-(Dark).png')}
        />
        <Text style={{fontSize: 20, fontWeight: '600', color: '#EFF3F5', marginBottom: 20}}>Centros INAH</Text>
        <View style={styles.actionsContainer}>
            <TouchableOpacity
                style={styles.actionButton}
                onPress={() => navigation.navigate('AddCenter')}
            >
                <Text style={styles.actionButtonText}>Añadir</Text>
            </TouchableOpacity>

            <TouchableOpacity
                style={styles.actionButton}
                onPress={() => navigation.navigate('AddCenterInfo')}
            >
                <Text style={styles.actionButtonText}>Añadir Informacion</Text>
            </TouchableOpacity>

            <TouchableOpacity
                style={styles.actionButton}
                onPress={() => navigation.navigate('ModifyCenter')}
            >
                <Text style={styles.actionButtonText}>Modificar</Text>
            </TouchableOpacity>

            <TouchableOpacity
                style={styles.actionButton}
                onPress={() => navigation.navigate('DeleteCite')}
            >
                <Text style={styles.actionButtonText}>Eliminar</Text>
            </TouchableOpacity>

            <TouchableOpacity
                style={styles.actionButton}
                onPress={() => navigation.navigate('Centers')}
            >
                <Text style={styles.actionButtonText}>Ver Sitios</Text>
            </TouchableOpacity>
        </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
    mainContainer: {
        flex: 1,
        alignItems: 'center',
        justifyContent: 'center',
        backgroundColor: '#192229',
    },

    actionsContainer: {
        width: '90%',
        padding: 20,
        borderRadius: 16,
        backgroundColor: '#212E36',
        justifyContent: 'center',
        alignItems: 'center',
    },

    actionButton: {
        width: '80%',
        marginVertical: 10,
        borderRadius: 16,
        alignItems: 'center',
        backgroundColor: '#6C4AB6',
    },

    actionButtonText: {
        color: '#C8CDD0',
        padding: 10
    }
});